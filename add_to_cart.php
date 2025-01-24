<?php
include('dbconnect.php'); // Include the database connection file

// Start the session to manage session variables
session_start();

// Check if the user is logged in via session or cookies
if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        echo "You need to log in to add products to your cart.";
        exit;
    }
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Check if the form was submitted and the product ID is set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id']; // Ensure product ID is an integer
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Default to 1 if quantity is not set

    // Only proceed if the quantity is greater than 0
    if ($quantity > 0) {
        // Check if the product is already in the cart
        $sql = "SELECT * FROM basket WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Product already in cart, update quantity
            $sql = "UPDATE basket SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iii', $quantity, $user_id, $product_id);
            $stmt->execute();
        } else {
            // Product not in cart, insert new record
            $sql = "INSERT INTO basket (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iii', $user_id, $product_id, $quantity);
            $stmt->execute();
        }

        // Remove the product from the wishlist
        $sql_remove_from_wishlist = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql_remove_from_wishlist);
        $stmt->bind_param('ii', $user_id, $product_id);
        $stmt->execute();

        // Close the prepared statements
        $stmt->close();
    }

    // Redirect to the cart page after adding the product
    header("Location: cart.php");
    exit;
} else {
    echo "Invalid request. Product ID or quantity missing.";
}
?>
