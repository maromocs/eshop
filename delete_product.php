<?php
session_start();
include 'dbconnect.php'; // Include your database connection file

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Check if product ID is provided
if (!isset($_GET['id'])) {
    header("Location: products_page.php"); // Redirect if no product ID is provided
    exit();
}

$product_id = (int)$_GET['id'];

// Delete the product only if it belongs to the seller
$stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    $success_message = "Product deleted successfully!";
} else {
    $error_message = "Failed to delete product or product not found.";
}

header("Location: products_page.php");
exit();
?>