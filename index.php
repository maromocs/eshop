<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="x-ua-compatible" content="IE=edge">
	<meta name="author" content="SemiColonWeb">
	<meta name="description" content="GamingUniverse is a website powered by Marinos Efthymiou. This website was built by gamers made for gamers!">

	<link rel="stylesheet" href="style/style.css">

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already started
}
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Include the appropriate header based on the role
if ($role == 'costumer') { 
    include 'header.php'; 
} elseif ($role == 'seller') { 
    include 'header_seller.php'; 
} else {
    // Optional: you can include a default header or redirect the user if they have an invalid role
    include 'header_guest.php'; 
}

?>

	<title>GamingUniverse</title>


	<style>
        /* General CSS for Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            text-align: center;
            border-radius: 10px;
        }
        .modal-content .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .modal-content .close:hover,
        .modal-content .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper">

		

		<!-- Introduction
		============================================= -->
		<div id="slider" class="slider-element dark vh-lg-100 include-header">
			<div class="vertical-middle">
				<div class="container mt-lg-5 py-5">
					<div class="row justify-content-center justify-content-lg-between g-5">
						<div class="col-lg-6">
							<h2 class="display-3 fw-bold ls-1 text-shadow-effect text-shadow-effect-size-4">GamingUniverse </h2>
							<p class="lead mb-5 fw-semibold">Welcome to GamingUniverse! Your one-stop shop for everything gaming.
								From the hottest video games to exclusive merch, gift codes, and more, we've got it all. 
								Explore, shop, and level up your gaming experience today!</p>
							<div>
							<a href="products_page.php" class="btn button-gaming text-larger font-primary all-ts fw-bold"><span class="button-span-text px-5">Enter Store Now!</span></a>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="video-wrap no-placeholder">
				<video poster="gaming/images/videos/video-poster.jpg" preload="auto" loop autoplay muted playsinline>
					<source src='gaming/images/videos/1.mp4' type='video/mp4'>
				</video>
				<div class="video-overlay" style="background: linear-gradient(to bottom, rgba(10, 19, 29, 0.5) 75%, #0a131d);"></div>
			</div>
		</div>



		<!-- Content
		============================================= -->
		<section id="content">
			<div class="content-wrap pb-3">
				<div class="container mb-4">
					<div class="row align-items-center g-4 dark">
						<div class="col-md-6 px-0 pe-md-5">
							<div class="cascading-images">
								<div class="cascading-images-inner">
									<div class="cascading-image p-0">
										<img src="https://cdn.sanity.io/images/dsfx7636/consumer_products/7347009e5671f4543bcefbaa10efb4458c06e0a9-2560x3200.png" alt="Kaisa Figure" class="z-1">
									</div>
									<div class="cascading-image d-none d-md-block scroll-detect z-2"  style="margin-top: -70px;">
										<img src="https://merch.riotgames.com/_next/image/?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fdsfx7636%2Fconsumer_products%2F496e62565cb0e4ff023a8c7e4739f16b06ff35e6-800x1000.png&w=828&q=75" alt="Katarina" data-animate="zoomIn faster" data-delay="200" class="end-0 mb-4 start-100" style="--cnvs-transitions:.2s linear; transform: translate3d(-100px, calc(var(--cnvs-scroll-percent) * 1px), 0); width: 280px;">
										<img src="https://merch.riotgames.com/_next/image/?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fdsfx7636%2Fconsumer_products_live%2F6bb5f2c67b40bc7c7b3dfdeff19ef90bd2e396a6-2560x2560.png&w=828&q=75" alt="Irelia" data-animate="zoomIn faster" data-delay="300" class="start-0" style="--cnvs-transitions:.2s linear; transform: translate3d(-160px, calc(var(--cnvs-scroll-percent) * -1px), 0); width: 300px;">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 p-5 p-lg-6">
							<h2 class="display-5 text-light ls-1 fw-bolder text-shadow-effect text-shadow-effect-size-3">League of Legends Figures</h2>
							<img src="gaming/images/divider.svg" alt=".." width="200" class="mb-3">
							<p class="lead fw-normal">League of Legends figures are unique champions with distinct abilities and roles, driving strategic gameplay through teamwork and adaptability. These figures where made by Riot Games.</p>
							 <a href="products_page.php" class="btn button-gaming text-larger font-primary all-ts fw-bold"><span class="button-span-text px-5">Learn More</span></a>
						</div>
					</div>
				</div>

				<div class="clear"></div>

				<div class="section bg-transparent dark mb-3" style="margin-top: 0px; padding-bottom: 200px;">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-md-8">
								<div class="text-center">
									<img src="gaming/images/divider.svg" alt=".." width="200" class="mb-4">
									<h2 class="display-5 fw-bold mb-5 text-shadow-effect text-shadow-effect-size-3">Upcoming Game</h2>
									<img class="glow" src="images/witcher.png" width="1920" height="500">

									<iframe width="560" height="315"
													src="https://www.youtube.com/embed/yWMu6JeT2g8" 
													frameborder="0" 
													allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
													allowfullscreen
													class="iframe-content">
									</iframe>
								</div>
								
							</div>
						</div>
					</div>
				</div>

			

				<div class="clear"></div>

				<div class="section parallax scroll-detect dark">
					<img src="gaming/images/section.jpg" class="parallax-bg">
					<div class="bg-overlay z-1">
						<div class="bg-overlay-bg dark" style="background: linear-gradient(to bottom, #0a131d 5%, rgba(0,0,0,.4), #0a131d);"></div>
					</div>
					<div class="container text-center z-2 py-lg-5">
						<div class="row justify-content-center g-4">
							<div class="col-md-7">
								<img src="gaming/images/awards/reward-icon.svg" alt=".." width="160" class="mb-4">
								<h2 class="display-5 text-light text-uppercase ls-1 fw-bold text-shadow-effect text-shadow-effect-size-3">Milestones</h2>
								<p class="lead fs-5 fw-bold mb-5">🌟 On January 25th, 2025, the website was launched </p>
								<p class="lead fs-5 fw-bold mb-5">🌟 Over 10,000 products sold  </p>
								<p class="lead fs-5 fw-bold mb-5">🌟 Over 6,000 diverse games are now available on our website. </p>
							</div>
						</div>
					</div>
				</div>

				<div class="section dark bg-transparent my-0">
					<div class="container">
						<div class="row justify-content-center text-center">
							<div class="col-md-6">
								<img src="gaming/images/divider.svg" alt=".." width="140" class="mb-4">
								<h2 class="display-5 text-light text-uppercase ls-1 fw-bold mb-3 text-shadow-effect text-shadow-effect-size-3">Our Gallery</h2>
								<p class="lead fs-5 fw-bold mb-5">Progressively foster proactive collaboration.</p>
							</div>
						</div>
					</div>

					<div class="swiper_wrapper customjs h-auto mb-lg-6 mb-0" >
						<div class="swiper swiper-parent">
							<div class="swiper-wrapper align-items-center">
								<div class="swiper-slide">
									<img src="images/1.jpg" alt="..">
								</div>

								<div class="swiper-slide">
									<img src="images/2.jpg" alt="..">
								</div>

								<div class="swiper-slide">
									<img src="images/3.jpg" alt="..">
								</div>

								<div class="swiper-slide">
									<img src="images/4.jpg" alt="..">
								</div>

								<div class="swiper-slide">
									<img src="images/5.jpg" alt="..">
								</div>

							</div>
							<div class="slider-arrow-left">
								<svg viewBox="0 0 95.482 23.979" xmlns="http://www.w3.org/2000/svg"> <g transform="translate(116.54 -52.158) rotate(90)"> <path d="M75.9,44.773a11.571,11.571,0,0,0-11.751-2.284A11.571,11.571,0,0,0,52.4,44.773a.717.717,0,0,0,.135,1.163.707.707,0,0,0,.667.007,13.173,13.173,0,0,1,11.078-.065,12.6,12.6,0,0,1,10.821.065.707.707,0,0,0,.667-.007h0A.716.716,0,0,0,75.9,44.773Z"/> <path d="M64.147,97.466c-.308-2.976-.478-6.2-.5-9.468L63.6,46.352a12.678,12.678,0,0,0-3.978-.922l1.734,58.46a34.765,34.765,0,0,0,2.787,12.645V97.466Z"/> <path d="M64.645,88c-.019,3.272-.189,6.492-.5,9.468v19.069a34.766,34.766,0,0,0,2.788-12.645l1.733-58.449a12.117,12.117,0,0,0-3.977,1.024Z"/> <rect transform="translate(60.944 28.614)" width="6.406" height="15.287"/> <rect transform="translate(58.244 26.956) rotate(-45)" width="8.349" height="8.349"/></g></svg>
							</div>
							<div class="slider-arrow-right">
								<svg viewBox="0 0 95.482 23.979" xmlns="http://www.w3.org/2000/svg"> <g transform="translate(-21.052 76.137) rotate(-90)"> <path d="M75.9,44.773a11.571,11.571,0,0,0-11.751-2.284A11.571,11.571,0,0,0,52.4,44.773a.717.717,0,0,0,.135,1.163.707.707,0,0,0,.667.007,13.173,13.173,0,0,1,11.078-.065,12.6,12.6,0,0,1,10.821.065.707.707,0,0,0,.667-.007h0A.716.716,0,0,0,75.9,44.773Z"/> <path d="M64.147,97.466c-.308-2.976-.478-6.2-.5-9.468L63.6,46.352a12.678,12.678,0,0,0-3.978-.922l1.734,58.46a34.765,34.765,0,0,0,2.787,12.645V97.466Z"/> <path d="M64.645,88c-.019,3.272-.189,6.492-.5,9.468v19.069a34.766,34.766,0,0,0,2.788-12.645l1.733-58.449a12.117,12.117,0,0,0-3.977,1.024Z"/> <rect transform="translate(60.944 28.614)" width="6.406" height="15.287"/> <rect transform="translate(58.244 26.956) rotate(-45)" width="8.349" height="8.349"/> </g></svg>

							</div>
						</div>
					</div>
				</div>
				        <!-- Modal -->
						<div class="modal1 mfp-hide" id="myModal1" aria-labelledby="modalTitle" aria-describedby="modalDescription">
							<div class="block mx-auto" style="background-color: #FFF; max-width: 700px;">
								<div class="text-center" style="padding: 50px;">
									<h3 id="modalTitle">Sign In Required to Continue</h3>
									<p id="modalDescription" class="mb-0">You need to sign in to access this content.</p>
								</div>
								<div class="section text-center m-0" style="padding: 30px;">
								<a href="login.php" class="button modal-cookies-close" onClick="window.location='login.php';">Sign In</a>
								<a href="signup.php" class="button modal-cookies-close" onClick="window.location='signup.php';">Sign Up</a>
								</div>
							</div>
						</div>


			</div>
		</section><!-- #content end -->

		<?php include 'footer.php'; ?>

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="rounded-circle"><img class="position-relative" style="top: -1px" src="gaming/images/icons/top.svg" alt=".." height="26"></div>

	<script>

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('a');
    buttons.forEach(button => {
        button.addEventListener('click', function (event) {
            // Check if the link has the 'no-modal' class
            if (button.classList.contains('no-modal')) {
                return; // Do nothing if it's the login link
            }
            
            <?php if (!isset($_SESSION['role']) || !$_SESSION['role']): ?>
                event.preventDefault(); // Prevent default behavior
                jQuery.magnificPopup.open({
                    items: {
                        src: '#myModal1'
                    },
                    type: 'inline'
                });
            <?php endif; ?>
        });
    });
});		
  
    </script>

</body>
</html>