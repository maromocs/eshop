<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - GameFlix</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="styletest.css?v=<?php echo time(); ?>">
    
    <?php
    session_start(); // Start the session to access user data
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

    // Include the appropriate header based on the role
    if ($role == 'costumer') { 
        include 'header.php'; 
    } elseif ($role == 'seller') { 
        include 'header_seller.php'; 
    } else {
        include 'header_guest.php'; 
    }
    ?>

    <style>

    /* Container for the search bar */
.search-bar-container {
    margin-top: 30px;
    padding: 15px;
    background-color: #f4f4f4;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.search-bar-container h3 {
    font-size: 20px;
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
}

/* Style for the search input field */
.search-input {
    width: 80%;
    padding: 10px;
    margin-right: 10px;
    font-size: 16px;
    border: 2px solid #ddd;
    border-radius: 5px;
    transition: border-color 0.3s;
}

.search-input:focus {
    outline: none;
    border-color:rgb(213, 91, 91);
}

/* Style for the search button */
.search-button {
    padding: 10px 15px;
    font-size: 16px;
    color: white;
    background-color: #b64848;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.search-button:hover {
    background-color:rgb(131, 20, 20);
}

.search-button:active {
    background-color:#b64848;
}

/* Responsive design for mobile */
@media (max-width: 600px) {
    .search-bar-container {
        text-align: center;
    }

    .search-input {
        width: 100%;
        margin-right: 0;
    }

    .search-button {
        width: 100%;
        margin-top: 10px;
    }
}



    </style>
</head>
<body class="stretched page-transition" data-loader-html="<div></div>">
  
<div id="wrapper">      
    
    <main>
        <section class="page-title page-title-parallax parallax scroll-detect py-lg-6">
            <img style="margin-top: 60px;" src="images/boarder_products.png" class="parallax-bg">
            <div class="container">
                <div class="page-title-row py-6">
        
                </div>
            </div>
        </section>

        <!-- Main layout with sorting on the left and products on the right -->
        <div class="product-container">
            <div class="sorting-sidebar" style="height: 400px;">
                <h3>Sort By</h3>
                
                <!-- Sort by Name A-Z, Z-A, Price High-Low, Price Low-High -->
                <div>
                    <input id="name_asc" class="radio-style" name="sort_by" type="radio" value="name_asc" 
                        <?php echo (!isset($_GET['sort_by']) || $_GET['sort_by'] == 'name_asc') ? 'checked' : ''; ?>>
                    <label for="name_asc" class="radio-style-2-label">Name (A to Z)</label>
                </div>
                <div>
                    <input id="name_desc" class="radio-style" name="sort_by" type="radio" value="name_desc" 
                        <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name_desc') ? 'checked' : ''; ?>>
                    <label for="name_desc" class="radio-style-2-label">Name (Z to A)</label>
                </div>
                <div>
                    <input id="price_desc" class="radio-style" name="sort_by" type="radio" value="price_desc" 
                        <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_desc') ? 'checked' : ''; ?>>
                    <label for="price_desc" class="radio-style-2-label">Cost (High to Low)</label>
                </div>
                <div>
                    <input id="price_asc" class="radio-style" name="sort_by" type="radio" value="price_asc" 
                        <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_asc') ? 'checked' : ''; ?>>
                    <label for="price_asc" class="radio-style-2-label">Cost (Low to High)</label>
                </div>

               <!-- Search Bar -->
               
                    <h3 style="margin-top:30px; margin-bottom:-2px;">Search</h3>
                    <form method="GET" action="" class="search-form">
                        <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="search-input">
                        <button type="submit" class="search-button" style="margin-top:5px;">Search</button>
                    </form>
            </div>

            <div id="product-grid">
                <?php
                // Include the product fetching PHP code with pagination
                include('fetch_products.php');
                ?>
            </div>

        </div>
    </main>

</div>

</body>
</html>

<script>
document.querySelectorAll('input[name="sort_by"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        const sortBy = this.value;
        const urlParams = new URLSearchParams(window.location.search);
        const currentPage = urlParams.get('page') || 1; // Get current page or default to 1

        // Redirect with the selected sort option and current page
        window.location.href = `?page=${currentPage}&sort_by=${sortBy}`;
    });
});
</script>

<?php include 'footer.php'; ?>
