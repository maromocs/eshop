<?php
session_start();
include('dbconnect.php'); // Include the database connection

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to view your orders.";
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve logged-in user's ID
$role = isset($_SESSION['role']) ? $_SESSION['role'] : ''; // Retrieve the user's role from the session

// Fetch the ordered products for the user
$sql = "SELECT p.name, op.price, op.quantity, (op.price * op.quantity) AS total
        FROM ordered_products op
        JOIN products p ON op.product_id = p.id
        WHERE op.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders - GameFlix</title>
    <link rel="stylesheet" href="style/style.css">

    <style>
        .cart td {
            text-align: center;
        }
    </style>
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
<body class="stretched page-transition" data-loader-html="<div></div>">
    <div id="wrapper">
        <section id="content">
            <div class="content-wrap">
                <div class="container">
                    <h2 style="color:#fff">Your Orders</h2>
                    <table class="table cart mb-5">
                        <thead>
                            <tr>
                                <th class="cart-product-name">Product</th>
                                <th class="cart-product-price">Unit Price</th>
                                <th class="cart-product-quantity">Quantity</th>
                                <th class="cart-product-subtotal">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $subtotal = $row['total'];
                                    $total += $subtotal;
                                    echo "<tr>
                                            <td style='text-align:left;'>" . htmlspecialchars($row['name']) . "</td>
                                            <td>$" . number_format($row['price'], 2) . "</td>
                                            <td>" . $row['quantity'] . "</td>
                                            <td>$" . number_format($subtotal, 2) . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>You have not placed any orders yet.</td></tr>";
                            }
                            ?>
                            <tr>
                                <td colspan="3" style="text-align:left;"><strong>Grand Total</strong></td>
                                <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
