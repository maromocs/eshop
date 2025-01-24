<?php
session_start();
include('dbconnect.php'); // Include the database connection

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to add products to your wishlist.";
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve logged-in user's ID

if (isset($_POST['product_id'])) {  // Change from $_GET to $_POST
    $product_id = $_POST['product_id']; // Get product_id from POST data

    // Check if the product is already in the wishlist
    $sql_check = "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows == 0) {
        // Add product to wishlist
        $sql = "INSERT INTO wishlist (user_id, product_id) VALUES ($user_id, $product_id)";
        if ($conn->query($sql)) {
            header("Location: wishlist.php"); // Redirect to wishlist page
            exit;
        } else {
            echo "Error adding product to wishlist.";
        }
    } else {
        echo "Product already in wishlist.";
    }
} else {
    echo "No product ID specified.";
}

$conn->close();
?>
