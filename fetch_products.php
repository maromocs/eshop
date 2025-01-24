<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kataflix";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clean up and ensure there is no extra whitespace in the search term
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query = "";

// Enhanced search logic: Ensure both the column and input are in lowercase for case-insensitivity
if ($search) {
    // Use LOWER() to ensure case-insensitive matching
    $search_query = " AND LOWER(name) LIKE LOWER('%" . $conn->real_escape_string($search) . "%')";
}

$query = "SELECT * FROM products WHERE 1=1" . $search_query . " ORDER BY name ASC"; // Default sorting

// Get current page and number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

// Get sorting option from the GET request
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'price_asc';
switch ($sort_by) {
    case 'name_asc':
        $order_by = 'ORDER BY p.name ASC';
        break;
    case 'name_desc':
        $order_by = 'ORDER BY p.name DESC';
        break;
    case 'price_asc':
        $order_by = 'ORDER BY p.price ASC';
        break;
    case 'price_desc':
        $order_by = 'ORDER BY p.price DESC';
        break;
    case 'newest':
        $order_by = 'ORDER BY p.created_at DESC';
        break;
    default:
        $order_by = 'ORDER BY p.name ASC';
}

// Fetch user details
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? null;

// Fetch products with pagination
$sql = "SELECT p.id, p.name, p.description, p.price, p.photo, p.type, u.username AS seller, p.seller_id
        FROM products p
        JOIN user u ON p.seller_id = u.id
        WHERE 1=1 $search_query
        $order_by
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

// Display products
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product col-12 col-sm-6 col-lg-12' style='background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(255, 21, 21, 0.77); margin-bottom: 20px;'>";
        echo "<div class='grid-inner row g-0'>";

        // Product image and sale badge
        echo "<div class='product-image col-lg-4 col-xl-3'>";
        echo "<a href='#'><img src='" . htmlspecialchars($row["photo"]) . "' alt='" . htmlspecialchars($row["name"]) . "' style='width: 100%;'></a>";
        echo "</div>";

        // Product description and buttons
        echo "<div class='product-desc col-lg-8 col-xl-9 px-lg-5 pt-lg-0'>";
        echo "<div class='product-title'><h3>" . htmlspecialchars($row["name"]) . "</h3></div>";
        echo "<div class='product-price'><ins>$" . number_format($row["price"], 2) . "</ins></div>";
        echo "<p class='mt-3 d-none d-lg-block'>" . htmlspecialchars(substr($row["description"], 0, 150)) . "</p>";

        // Display seller name
        echo "<p class='mt-3 d-none d-lg-block'>Seller name: <strong>" . htmlspecialchars($row["seller"]) . "</strong></p>";

        // Buttons for cart and wishlist
        echo "<form action='add_to_cart.php' method='POST'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' name='add-to-cart' class='btn btn-dark me-2'><i class='bi-bag-plus'></i> Add to Cart</button>";
        echo "</form>";

        echo "<form action='add_to_wishlist.php' method='POST'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' name='add-to-wishlist' class='btn btn-dark'><i class='bi-heart'></i> Add to Wishlist</button>";
        echo "</form>";

        // Show "Edit" and "Delete" buttons if the user is a seller and owns the product
        if ($user_role === 'seller' && $row['seller_id'] == $user_id) {
            echo "<div class='seller-actions mt-3'>";
            echo "<a href='edit_product.php?id=" . $row['id'] . "' class='btn btn-primary me-2'>Edit</a>";

            // Add link to open delete modal
            echo "<a href='#' class='btn btn-danger' onclick='showDeleteModal(" . $row['id'] . ", \"" . htmlspecialchars($row["name"]) . "\"); return false;'>Delete</a>";
            echo "</div>";
        }

        echo "</div>";
        echo "</div>"; // Close grid-inner
        echo "</div>"; // Close product
    }
} else {
    echo "<p>No products available.</p>";
}

// Pagination logic
$sql_count = "SELECT COUNT(*) AS total FROM products WHERE 1=1" . $search_query; // Include search query in count
$result_count = $conn->query($sql_count);

if ($result_count && $row_count = $result_count->fetch_assoc()) {
    $total_products = $row_count['total'];
    $total_pages = ceil($total_products / $limit);
    
    // Ensure we don't show more pages than necessary
    if ($total_products <= $limit) {
        $total_pages = 1; // If fewer products than the limit, just show one page
    }
} else {
    $total_products = 0;
    $total_pages = 1; // Default to 1 page to avoid division by zero
}

// Display pagination only if there's more than one page
if ($total_products > $limit) {
    echo "<div class='pagination-container'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        $active_class = $i == $page ? 'active' : '';
        echo "<a href='?page=$i&sort_by=$sort_by' class='pagination-button $active_class'>$i</a>";
    }
    echo "</div>"; // Close pagination-container
}

// Close database connection
$conn->close();
?>

<!-- Modal for Confirmation -->
<div class="modal1 mfp-hide" id="myModal1">
    <div class="block mx-auto" style="background-color: #FFF; max-width: 700px;">
        <div class="text-center" style="padding: 50px;">
            <h3>Are you sure you want to delete this product?</h3>
            <p id="modalProductName"></p>
        </div>
        <div class="section text-center m-0" style="padding: 30px;">
            <a href="#" class="button" id="deleteButton">Delete</a>
            <a href="#" class="button modal-cookies-close" onClick="jQuery.magnificPopup.close(); return false;">Back</a>
        </div>
    </div>
</div>

<script>
function showDeleteModal(productId, productName) {
    // Open the modal
    jQuery.magnificPopup.open({
        items: {
            src: '#myModal1',
            type: 'inline'
        },
        preloader: false
    });

    // Set the product name in the modal
    document.getElementById('modalProductName').innerHTML = 
        '<strong>Product: ' + productName + '</strong><br>' +
        'Deleting this product will remove it from the store.';

    // Set the delete button's href to the delete URL
    document.getElementById('deleteButton').href = 'delete_product.php?id=' + productId;
}
</script>
