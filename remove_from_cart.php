<?php
include('dbconnect.php'); // Include the database connection file

session_start(); // Start the session to access session variables

// Check if the user is logged in via session or cookies
if (!isset($_SESSION['user_id'])) {
    // If not, check if cookies are set
    if (isset($_COOKIE['user_id'])) {
        // If cookies exist, log the user in via the cookies
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        echo "You need to log in to remove items from the cart.";
        exit; // Exit if user is not logged in
    }
}

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id']; // Get the product ID from the query string
    $user_id = $_SESSION['user_id']; // Get the user ID from session

    // Remove the item from the cart
    $sql = "DELETE FROM basket WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    if ($stmt->execute()) {
        // Redirect to the cart page after removal
        header("Location: cart.php");
        exit;
    } else {
        echo "Error removing item from cart.";
    }
} else {
    echo "Invalid product ID.";
}
?>