<?php
session_start();
include('dbconnect.php'); // Include the database connection

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to proceed to checkout.";
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve logged-in user's ID

// Fetch the cart items for the user
$sql = "SELECT p.id, p.name, p.price, p.photo, b.quantity
        FROM basket b
        JOIN products p ON b.product_id = p.id
        WHERE b.user_id = $user_id";
$result = $conn->query($sql);

// Check if a coupon is set
$coupon_discount = isset($_SESSION['coupon_discount']) ? $_SESSION['coupon_discount'] : 0;

// Handle order confirmation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    // Calculate total and distribute discount across items proportionally
    $total = 0;
    foreach ($_POST['product_id'] as $key => $product_id) {
        $quantity = $_POST['quantity'][$key];
        $price = $_POST['price'][$key];
        $total += $price * $quantity;
    }

    // Apply the discount proportionally to each product
    foreach ($_POST['product_id'] as $key => $product_id) {
        $quantity = $_POST['quantity'][$key];
        $price = $_POST['price'][$key];
        $subtotal = $price * $quantity;

        // Calculate proportional discount
        $proportional_discount = ($subtotal / $total) * $coupon_discount;
        $discounted_price = max(0, $price - ($proportional_discount / $quantity));

        // Insert into ordered_products
        $sql_order = "INSERT INTO ordered_products (user_id, product_id, quantity, price) 
                      VALUES ($user_id, $product_id, $quantity, $discounted_price)";
        $conn->query($sql_order);

        // Remove the item from the cart
        $sql_remove = "DELETE FROM basket WHERE user_id = $user_id AND product_id = $product_id";
        $conn->query($sql_remove);
    }

    // Clear coupon from session after order is placed
    unset($_SESSION['coupon_discount']);

    // Redirect to ordered.php
    header("Location: ordered.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - GameFlix</title>
    <link rel="stylesheet" href="style/style.css">
    <?php include 'header.php'; ?>
</head>
<body class="stretched page-transition" data-loader-html="<div></div>">
    <div id="wrapper">
        <section id="content">
            <div class="content-wrap">
                <div class="container">
                    <h2 style="color:#fff;">Confirm Your Order</h2>
                    <form method="POST" action="checkout.php">
                        <table class="table cart mb-5">
                            <thead>
                                <tr>
                                    <th class="cart-product-thumbnail">Image</th>
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
                                        $subtotal = $row['price'] * $row['quantity'];
                                        $total += $subtotal;
                                        echo "<tr>
                                                <td><img width='64' height='64' src='" . $row['photo'] . "' alt='" . $row['name'] . "'></td>
                                                <td>" . $row['name'] . "</td>
                                                <td>$" . number_format($row['price'], 2) . "</td>
                                                <td>" . $row['quantity'] . "</td>
                                                <td>$" . number_format($subtotal, 2) . "</td>
                                                <input type='hidden' name='product_id[]' value='" . $row['id'] . "'>
                                                <input type='hidden' name='quantity[]' value='" . $row['quantity'] . "'>
                                                <input type='hidden' name='price[]' value='" . $row['price'] . "'>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Your cart is empty.</td></tr>";
                                }

                                // Calculate the final total, ensuring it doesn't go below 0
                                $final_total = max(0, $total - $coupon_discount);
                                ?>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td>$<?php echo number_format($total, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4">Coupon Discount</td>
                                    <td>$<?php echo number_format($coupon_discount, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><strong>Grand Total</strong></td>
                                    <td><strong>$<?php echo number_format($final_total, 2); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="display: flex; justify-content: space-between;">
                            <a href="cart.php" class="button button-3d button-black">Go Back</a>
                            <button type="submit" name="confirm_order" class="button button-3d button-black">Confirm Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
