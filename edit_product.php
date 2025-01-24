<?php
session_start();
include 'dbconnect.php'; // Include your database connection file

// Check if the user is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php"); // Redirect to login if not a seller
    exit();
}

$seller_id = $_SESSION['user_id'];

// Ensure the product ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: product_page.php"); // Redirect if no product ID
    exit();
}

$product_id = (int)$_GET['id'];

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: product_page.php"); // Redirect if unauthorized or no product found
    exit();
}

$product = $result->fetch_assoc();

// Handle form submission for updating a product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $photo = $_FILES['photo'];
    $photo_path = $product['photo']; // Keep existing photo by default

    // Directory to store uploaded photos
    $uploads_dir = "uploads/";
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true); // Create the directory if it doesn't exist
    }

    // Handle photo upload if a new photo is provided
    if (!empty($photo['name'])) {
        $photo_name = time() . '_' . basename($photo['name']);
        $new_photo_path = $uploads_dir . $photo_name;

        if (move_uploaded_file($photo['tmp_name'], $new_photo_path)) {
            $photo_path = $new_photo_path; // Update the photo path
        } else {
            $error_message = "Failed to upload photo. Please ensure the uploads directory exists and is writable.";
        }
    }

    // Update the product in the database
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, photo = ?, type = ? WHERE id = ? AND seller_id = ?");
    $stmt->bind_param("ssdssii", $name, $description, $price, $photo_path, $type, $product_id, $seller_id);

    if ($stmt->execute()) {
        $success_message = "Product updated successfully!";
        $show_modal = true;  // Show success modal
    } else {
        $error_message = "Failed to update product. Please try again.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start the session only if it's not already started
    }
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

    // Include the appropriate header based on the role
    if ($role == 'costumer') { 
        include 'header.php'; 
    } elseif ($role == 'seller') { 
        include 'header_seller.php'; 
    } else {
        include 'header_guest.php'; 
    }
    ?>
    <title>Edit Product Page</title>
    <style>
        /* Custom styles for the page */
        body {
            background: #1c1f24;
            color: #ffffff;
        }
        #wrapper {
            max-width: 800px;
            margin: 50px auto;
            background: #2c3036;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
        h1, h2 {
            text-align: center;
            color: #d9534f;
        }
        .message {
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .message.success {
            background: #28a745;
            color: #ffffff;
        }
        .message.error {
            background: #dc3545;
            color: #ffffff;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        textarea,
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }
        input[type="text"],
        textarea {
            background: #3a3f47;
            color: #ffffff;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        input[type="file"] {
            background: #d9534f;
        }
        button {
            background: #d9534f;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #c9302c;
        }
    </style>
</head>

<body class="stretched page-transition" data-loader-html="<div></div>">

<div id="wrapper" style="place-self:center;">
    <h1>Welcome, Seller <?php echo $username; ?></h1>
    <h2>Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter product name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" placeholder="Enter product description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" placeholder="Enter product price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" placeholder="Enter product type" value="<?php echo htmlspecialchars($product['type']); ?>" required>

        <label for="photo">Upload a Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
        
        <div>
            <img id="imagePreview" src="" alt="Image Preview" style="display:none;" >
        </div>

        <button type="submit">Submit Changes</button>
    </form>
</div>

<!-- Modal for Success -->
<?php if (isset($show_modal) && $show_modal): ?>
    <div class="modal1 mfp-hide" id="myModal1">
        <div class="block mx-auto" style="background-color: #FFF; max-width: 700px;">
            <div class="text-center" style="padding: 50px;">
                <h3>Product Updated Successfully!</h3>
                <p class="mb-0" style="color:black;">Your product has been updated successfully.</p>
            </div>
            <div class="section text-center m-0" style="padding: 30px;">
                <a href="index.php" class="button modal-cookies-close" id="homeButton">Home</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    function previewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('imagePreview');
            preview.src = reader.result;
            preview.style.display = 'block'; // Show the preview image
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    $(document).ready(function() {
        // Initialize magnific popup
        $('.modal1').magnificPopup({
            type: 'inline',
            closeOnBgClick: false
        });

        // Redirect logic for buttons
        $('#homeButton').click(function() {
            window.location.href = "index.php"; // Redirect to home
        });

        $('#addMoreButton').click(function() {
            window.location.href = "sellerpage.php"; // Redirect to seller page
        });
    });

    <?php if (isset($show_modal) && $show_modal): ?>
        // Open the modal programmatically after product is updated
        jQuery.magnificPopup.open({
            items: {
                src: '#myModal1',
                type: 'inline'
            },
            closeOnBgClick: false
        });
    <?php endif; ?>
</script>

<?php include 'footer.php'; ?>

</body>
</html>
