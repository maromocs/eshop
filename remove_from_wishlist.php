<?php
session_start();
include('dbconnect.php'); // Include the database connection

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to remove products from your wishlist.";
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve logged-in user's ID

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Remove the product from the wishlist
    $sql_remove = "DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";
    if ($conn->query($sql_remove)) {
        header("Location: wishlist.php"); // Redirect to wishlist page
        exit;
    } else {
        echo "Error removing product from wishlist.";
    }
} else {
    echo "No product ID specified.";
}
?>
