<?php
include('dbconnect.php'); // Include the database connection file

session_start();
if (!isset($_SESSION['user_id'])) {
    // Check if cookies are available and restore session variables if necessary
    if (isset($_COOKIE['user_id'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
}

// Check if the user is logged in via session or cookies
if (!isset($_SESSION['user_id'])) {
    // If not, check if cookies are set
    if (isset($_COOKIE['user_id'])) {
        // If cookies exist, log the user in via the cookies
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        echo "You need to log in to view your cart.";
        exit; // Exit if user is not logged in
    }
}

$user_id = $_SESSION['user_id']; // Retrieve the logged-in user's ID

// Handle the "Update Cart" request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $quantity = (int)$quantity; // Ensure the quantity is an integer
        if ($quantity > 0) {
            $sql = "UPDATE basket SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iii', $quantity, $user_id, $product_id);
            $stmt->execute();
            $stmt->close();
        } else {
            // If quantity is 0 or negative, remove the item from the cart
            $sql = "DELETE FROM basket WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $user_id, $product_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    // Redirect back to the cart page after updating
    header("Location: cart.php");
    exit;
}

// Apply Coupon Logic
$cart_total = 0; // Initialize the cart total
// Apply Coupon Logic
$coupon_discount = 0; // Initialize the coupon discount

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_coupon'])) {
    $coupon_code = $_POST['coupon_code'];
    switch ($coupon_code) {
        case "2025":
            $coupon_discount = 3;
            break;
        case "ILOVE476":
            $coupon_discount = 5;
            break;
        case "PHPDREAM":
            $coupon_discount = 5;
            break;
        case "GAMEFLIX":
            $coupon_discount = 7.5;
            break;
        case "KATAFLIX":
            $coupon_discount = 10;
            break;
        default:
            $coupon_discount = 0; // Invalid coupon
            break;
    }
    $_SESSION['coupon_discount'] = $coupon_discount; // Save the coupon value in session
}


// Fetch cart items for the logged-in user
$sql = "SELECT p.id, p.name, p.price, p.photo, b.quantity
        FROM basket b
        JOIN products p ON b.product_id = p.id
        WHERE b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - GameFlix</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="styletest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

switch ($role) {
    case 'costumer':
        include 'header.php';
        break;
    case 'seller':
        include 'header_seller.php';
        break;
    default:
        include 'header_guest.php';
        break;
}
?>
</head>
<body class="stretched page-transition" data-loader-html="<div></div>">
    <div id="wrapper">
        <section id="content">
            <div class="content-wrap">
                <div class="container">
                <h2 style="color:#ffffff;">Your Cart</h2>
                    <div class="row">
                        <div class="col-xl-8">
                            <form method="POST" action="cart.php"> <!-- Change action to cart.php -->
                                <table class="table cart mb-5">
                                    <thead>
                                        <tr>
                                        <th class="cart-product-thumbnail">&nbsp;</th> <!-- Shifted left -->
                                        <th class="cart-product-name">Product</th>
                                        <th class="cart-product-price">Unit Price</th>
                                        <th class="cart-product-quantity">Quantity</th>
                                        <th class="cart-product-subtotal">Total</th>
                                        <th class="cart-product-remove">&nbsp;</th> <!-- Only for remove button -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $subtotal = $row["price"] * $row["quantity"];
                                                $cart_total += $subtotal; // Add the subtotal to the cart total
                                            
                                                echo "<tr class='cart_item'>
                                                <td class='cart-product-thumbnail'>
                                                    <a href='#'><img width='64' height='64' src='" . $row["photo"] . "' alt='" . $row["name"] . "'></a>
                                                </td>
                                                <td class='cart-product-name'>
                                                    <a href='#'>" . $row["name"] . "</a>
                                                </td>
                                                <td class='cart-product-price'>
                                                    <span class='amount'>$" . number_format($row["price"], 2) . "</span>
                                                </td>
                                                <td class='cart-product-quantity'>
                                                    <div class='quantity'>
                                                        <input type='button' value='-' class='minus'>
                                                        <input type='number' name='quantity[" . $row["id"] . "]' value='" . $row["quantity"] . "' class='qty' min='1'>
                                                        <input type='button' value='+' class='plus'>
                                                    </div>
                                                </td>
                                                <td class='cart-product-subtotal'>
                                                    <span class='amount'>$" . number_format($subtotal, 2) . "</span>
                                                </td>
                                                <td class='cart-product-remove'>
                                                    <a href='remove_from_cart.php?product_id=" . $row["id"] . "' class='remove' title='Remove this item'>
                                                        <i class='fa-solid fa-trash'></i> Remove
                                                    </a>
                                                </td>
                                            </tr>";
                                            
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
                                        }
                                        ?>
                                        <tr class="cart_item">
                                            <td colspan="6">
                                                <div class="row justify-content-between align-items-center py-2 col-mb-30">
                                                    <div class="col-lg-auto ps-lg-0">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-8">
                                                                <input type="text" name="coupon_code" value="" class="form-control text-center text-md-start" placeholder="Enter Coupon Code..">
                                                            </div>
                                                            <div class="col-md-4 mt-3 mt-md-0">
                                                                <button type="submit" name="apply_coupon" class="button button-small button-3d button-black m-0" style="--cnvs-btn-padding-y:7px;line-height:22px;">Apply Coupon</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-auto pe-lg-0">
                                                        <button type="submit" name="update_cart" class="button button-small button-3d m-0">Update Cart</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>

                        <div class="col-xl-4">
                            <div class="grid-inner bg-light p-5 rounded">
                                <div class="row col-mb-30">
                                    <div class="col-12">
                                        <h4>Cart Totals</h4>
                                        <div class="table-responsive">
                                            <table class="table cart cart-totals">
                                                <tbody>
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name">
                                                            <h5 class="mb-0">Cart Subtotal</h5>
                                                        </td>
                                                        <td class="cart-product-name text-end">
                                                            <span class="amount">$<?php echo number_format($cart_total, 2); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name">
                                                            <h5 class="mb-0">Shipping</h5>
                                                        </td>
                                                        <td class="cart-product-name text-end">
                                                            <span class="amount">Free</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name">
                                                            <h5 class="mb-0">Coupon Discount</h5>
                                                        </td>
                                                        <td class="cart-product-name text-end">
                                                            <span class="amount">-$<?php echo number_format($coupon_discount, 2); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr class="cart_item">
                                                        <td class="cart-product-name">
                                                            <h5 class="mb-0">Total</h5>
                                                        </td>
                                                        <td class="cart-product-name text-end">
                                                            <?php
                                                            // Ensure the total never goes below 0
                                                            $final_total = max(0, $cart_total - $coupon_discount);
                                                            ?>
                                                            <span class="amount color lead fw-medium">$<?php echo number_format($final_total, 2); ?></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                    <a href="checkout.php" id="proceedToCheckout" class="button button-3d button-black d-block text-center m-0">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal1 mfp-hide" id="emptyCartModal">
                <div class="block mx-auto" style="background-color: #FFF; max-width: 700px;">
                    <div class="text-center" style="padding: 50px;">
                        <h3>Your Cart is Empty</h3>
                        <p class="mb-0">Please add items to your cart before proceeding to checkout.</p>
                    </div>
                    <div class="section text-center m-0" style="padding: 30px;">
                        <a href="#" class="button modal-cookies-close" onClick="jQuery.magnificPopup.close();return false;">Okay</a>
                    </div>
                </div>
            </div>


        </section><!-- #content end -->
    </div> <!-- Close wrapper -->
    <?php include('footer.php'); ?>

<script>
    document.getElementById('proceedToCheckout').addEventListener('click', function (event) {
        // Check if the cart is empty
        const cartIsEmpty = <?php echo ($result->num_rows > 0) ? 'false' : 'true'; ?>;

        if (cartIsEmpty) {
            event.preventDefault(); // Prevent redirection
            jQuery.magnificPopup.open({
                items: {
                    src: '#emptyCartModal'
                },
                type: 'inline'
            });
        }
    });
</script>

</body>
</html>
