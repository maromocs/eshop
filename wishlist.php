<?php
session_start();
include('dbconnect.php'); // Include the database connection

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to view your wishlist.";
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve logged-in user's ID
$role = isset($_SESSION['role']) ? $_SESSION['role'] : ''; // Retrieve the user's role from the session

// Fetch the wishlist items for the user
$sql = "SELECT p.id, p.name, p.price, p.photo, w.product_id 
        FROM wishlist w 
        JOIN products p ON w.product_id = p.id
        WHERE w.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wishlist - GameFlix</title>
    <link rel="stylesheet" href="style/style.css">

<?php // Include the appropriate header based on the role
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start the session only if it's not already started
    }
if ($role == 'costumer') { 
    include 'header.php'; 
} elseif ($role == 'seller') { 
    include 'header_seller.php'; 
} else {
    // Optional: you can include a default header or redirect the user if they have an invalid role
    include 'header_guest.php'; 
}?>
</head>
<body class="stretched page-transition">
    <div id="wrapper">
        <section id="content" style="height: 715px;">
            <div class="content-wrap">
                <div class="container">
                    <h2 style="color:#ffffff;">Your Wishlist</h2>
                    <table class="table cart mb-5">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td><img src='" . $row['photo'] . "' alt='" . $row['name'] . "' width='200' height='100'></td>
                                            <td>" . $row['name'] . "</td>
                                            <td>$" . number_format($row['price'], 2) . "</td>
                                            <td     style='text-align-last: center;' >
                                                <!-- Add to Cart button -->
                                                <form action='add_to_cart.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='product_id' value='" . $row['product_id'] . "'>
                                                    <button type='submit' name='add-to-cart' class='button button-3d button-black'>Add to Cart</button>
                                                </form>

                                                <!-- Remove from Wishlist button -->
                                                <form action='remove_from_wishlist.php' method='GET' style='display:inline;'>
                                                    <input type='hidden' name='product_id' value='" . $row['product_id'] . "'>
                                                    <button type='submit' class='button button-3d button-red'>Remove</button>
                                                </form>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Your wishlist is empty.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>