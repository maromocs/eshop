<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already started
}
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';

// Check if the user is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php"); // Redirect to login if not a seller
    exit();
}

// Database connection (ensure this is updated to match your database credentials)
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "kataflix";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding a product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $photo = $_FILES['photo'];
    $seller_id = $_SESSION['user_id']; // Get the seller's ID

    // Directory to store uploaded photos
    $uploads_dir = "uploads/";
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true); // Create the directory if it doesn't exist
    }

    // Create a unique name for the photo
    $photo_name = time() . '_' . basename($photo['name']);
    $photo_path = $uploads_dir . $photo_name;

    // Move uploaded file to the uploads directory
    if (move_uploaded_file($photo['tmp_name'], $photo_path)) {
        // Insert the product into the database, including the seller_id
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, photo, type, seller_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssi", $name, $description, $price, $photo_path, $type, $seller_id);

        if ($stmt->execute()) {
            // Trigger the modal by setting a success message and a flag for modal display
            $success_message = "Product added successfully!";
            $show_modal = true;
        } else {
            $error_message = "Failed to add product. Please try again.";
        }

        $stmt->close();
    } else {
        $error_message = "Failed to upload photo. Please ensure the uploads directory exists and is writable.";
    }
}

// Fetch the seller's uploaded products
$products = [];
$result = $conn->query("SELECT name, photo FROM products WHERE seller_id = " . $_SESSION['user_id']);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <title>Seller Page</title>
    <style>
        

        body {
            background: #1c1f24;
            color: #ffffff;
        }

        #wrapper {
            max-width: 800px;
            margin: 50px auto;
            background: #2c3036;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        h1, h2 {
            text-align: center;
            color: #d9534f;
        }

        .message {
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }

        .message.success {
            background: #28a745;
            color: #ffffff;
        }

        .message.error {
            background: #dc3545;
            color: #ffffff;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }

        input[type="text"],
        textarea {
            background: #3a3f47;
            color: #ffffff;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="file"] {
            background: #d9534f;
        }

        button {
            background: #d9534f;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #c9302c;
        }



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

<div id="wrapper" style="place-self:center;">
        <h1>Welcome, Seller <?php echo $username; ?></h1>
        <h2>Add a Product</h2>

        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter product name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter product description" required></textarea>

            <label for="price">Price:</label>
            <input type="text" id="price" name="price" placeholder="Enter product price" required>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" placeholder="Enter product type" required>

            <label for="photo">Upload a Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
            
            <div>
                <img id="imagePreview" src="" alt="Image Preview" style="display:none;" >
            </div>

            <button type="submit">Add Product</button>
        </form>
    </div>

<!-- Modal for Success -->
<?php if (isset($show_modal) && $show_modal): ?>
    <div class="modal1 mfp-hide" id="myModal1">
        <div class="block mx-auto" style="background-color: #FFF; max-width: 700px;">
            <div class="text-center" style="padding: 50px;">
                <h3>Product Added Successfully!</h3>
                <p class="mb-0" style="color:black;">Your product has been added successfully.</p>
            </div>
            <div class="section text-center m-0" style="padding: 30px;">
                <a href="index.php" class="button modal-cookies-close" id="homeButton">Home</a>
                <a href="sellerpage.php" class="button modal-cookies-close" id="addMoreButton">Add more</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Magnific Popup JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>


</body>
</html>

<script>
    function previewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('imagePreview');
            preview.src = reader.result;
            preview.style.display = 'block'; // Show the preview image
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    $(document).ready(function() {
    // Initialize magnific popup
    $('.modal1').magnificPopup({
        type: 'inline',
        closeOnBgClick: false
    });

    // When the Home button is clicked
    $('#homeButton').click(function() {
        window.location.href = "index.php"; // Redirect to home
    });

    // When the Add more button is clicked
    $('#addMoreButton').click(function() {
        window.location.href = "sellerpage.php"; // Redirect to seller page
    });
});

<?php if (isset($show_modal) && $show_modal): ?>
    // Open the modal programmatically after product is added
    jQuery.magnificPopup.open({
        items: {
            src: '#myModal1',
            type: 'inline'
        },
        closeOnBgClick: false
    });
<?php endif; ?>
</script>

<?php include 'footer.php'; ?>
