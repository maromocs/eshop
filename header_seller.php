
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already started
}
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="gaming/images/gaming%20universe.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
    <!-- Font Imports -->
    <link rel="stylesheet" href="https://use.typekit.net/fcr2yni.css">
    <!-- Font Icons -->
    <link rel="stylesheet" href="css/font-icons.css">
    <!-- Plugins/Components CSS -->
    <link rel="stylesheet" href="css/swiper.css">
    <!-- Niche Demos -->
    <link rel="stylesheet" href="css/gaming.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">


	<style>
/* Scrollbar Styles */
::-webkit-scrollbar {
    width: 12px;  /* Width of the scrollbar */
    height: 12px; /* Height for horizontal scrollbar */
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, #d9534f, #c9302c); /* Gradient from red to dark red */
    border-radius: 10px;  /* Rounded corners */
    border: 2px solid #212529;  /* Dark border around the thumb */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Subtle shadow effect */
    transition: background 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(45deg, #c9302c, #d9534f); /* Reverse gradient on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);  /* Stronger shadow on hover */
}

::-webkit-scrollbar-track {
	background: linear-gradient(45deg,#212529,#0a131d); /* Gradient from dark gray (#212529) to a slightly lighter gray (#343a40) */
    
}

    </style>


</head>
<body class="stretched page-transition" data-loader-html="<div></div>">
<!-- Header Costumer ============================================= -->
		<header id="header" class="transparent-header dark header-size-md" style="height: 100px;">
			<div id="header-wrap" class="border-bottom-0" >
				<div class="container">
					<div class="header-row justify-content-lg-between">
						<!-- Logo
						============================================= -->
						<div id="logo" class="col-lg-2 order-lg-2 me-auto">
							<a href="index.php">
								<img class="logo-default" src="gaming/images/gaming%20universe.png" alt="GameFlix Logo" style="width:100px; height:100px;">
								<img class="logo-dark" src="gaming/images/gaming%20universe.png" alt="GameFlix Logo" style="width:100px; height:100px;">
							</a>
						</div><!-- #logo end -->

						<!-- Header Buttons
						============================================= -->
						<div class="header-misc col-xl-5 col-lg justify-content-end ms-auto d-none d-md-flex">
							<!-- Display Username -->
							<span class="welcome-message font-primary" style="margin-right: 30px;">Hello, <?php echo $username; ?></span>
							<a href="sellerpage.php" class="button-gaming text-larger font-primary all-ts fw-bold me-3"><span class="button-span-text">Add Product</span></a>
							<a href="logout.php" class="button-gaming text-larger font-primary all-ts fw-bold me-3"><span class="button-span-text">Log-Out</span></a>
						</div>

						<div class="primary-menu-trigger col-auto">
							<button class="cnvs-hamburger" type="button">
								<span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
							</button>
						</div>

						<nav class="primary-menu col-xl-5 col-lg-6">
							<ul class="menu-container">
								<li class="menu-item"><a class="menu-link" href="index.php"><div>Home</div></a></li>
								<li class="menu-item"><a class="menu-link" href="products_page.php"><div>Store</div></a></li>
								<li class="menu-item"><a class="menu-link" href="cart.php"><div>Cart</div></a></li>
								<li class="menu-item"><a class="menu-link" href="wishlist.php"><div>Wishlist</div></a></li>
								<li class="menu-item"><a class="menu-link" href="ordered.php"><div>My Orders</div></a></li>
							</ul>
						</nav><!-- #primary-menu end -->
					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header><!-- #header end -->