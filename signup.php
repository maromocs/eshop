<?php 
session_start(); // Start the session
$showError = false;  
$exists = false; 
$username_error = "";
$email_error = "";
$password_error = "";

$email = $username = $password = $cpassword = $role = ""; // Initialize variables

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    include 'dbconnect.php';  

    $email = $_POST["email"];
    $username = $_POST["username"];  
    $password = $_POST["password"];  
    $cpassword = $_POST["cpassword"]; 
    $role = $_POST["role"];        

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format.";
    }

    // Check if username already exists
    $sql = "SELECT * FROM user WHERE username='$username'"; 
    $result = mysqli_query($conn, $sql); 
    $num = mysqli_num_rows($result);  

    if ($num > 0) { 
        $username_error = "Username already taken.";
    }

    // Check if passwords match
    if ($password !== $cpassword) {  
        $password_error = "Passwords do not match.";  
    }

    // If no errors, proceed with registration
    if (empty($email_error) && empty($username_error) && empty($password_error)) {
        $hash = password_hash($password, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO user (email, username, password, role, date) 
                VALUES ('$email', '$username', '$hash', '$role', current_timestamp())";
                    
        $insertResult = mysqli_query($conn, $sql);
        if ($insertResult) { 
            header("Location: SignupSuccess.html");
            exit();
        } else {
            $showError = "Error during sign up. Please try again.";
        }
    }
}
?>

<!DOCTYPE HTML> 
<html lang="en"> 

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="gaming/images/gaming%20universe.png">
    <link rel="stylesheet" href="style/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>

<body> 
    
<div class="logo-container">
    <img class="logo" style="width:150px; height:150px;" src="gaming/images/gaming%20universe.png"/>
</div>

<div class="container" style="height: 49rem;">
    <h1 style="margin-top: 30px;">Sign Up</h1>
    <div id="form">
        <form action="signup.php" method="post">
            
            <!-- Display error message for email (if set) -->
            <?php if ($email_error): ?>
                <p style=" font-family: 'Maven Pro', sans-serif; color:red; padding-bottom: 5px;"><?php echo $email_error; ?></p>
            <?php endif; ?>

            <div class="input-container input-value">
                <input type="text" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required />
                <label for="email">Email</label>
            </div>

            <!-- Display error message for username (if set) -->
            <?php if ($username_error): ?>
                <p style=" font-family: 'Maven Pro', sans-serif; color:red; padding-bottom: 5px;"><?php echo $username_error; ?></p>
            <?php endif; ?>

            <div class="input-container input-value">
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required />
                <label for="username">Username</label>
            </div>

            <div class="input-container input-value">
                <input type="password" name="password" id="password" class="form-control" value="<?php echo htmlspecialchars($password); ?>" required />
                <label for="password">Password</label>
            </div>

            <!-- Display error message for password mismatch -->
            <?php if ($password_error): ?>
                <p style=" font-family: 'Maven Pro', sans-serif; color:red; padding-bottom: 5px;"><?php echo $password_error; ?></p>
            <?php endif; ?>

            <div class="input-container input-value">
                <input type="password" name="cpassword" id="cpassword" class="form-control" value="<?php echo htmlspecialchars($cpassword); ?>" required />
                <label for="cpassword">Confirm Password</label>
            </div>

            <div class="custom-select">
                <select name="role" required>
                    <option value="" selected>Select role</option>
                    <option value="costumer" <?php echo ($role == 'costumer') ? 'selected' : ''; ?>>Costumer</option>
                    <option value="seller" <?php echo ($role == 'seller') ? 'selected' : ''; ?>>Seller</option>
                </select>
            </div>

            <div class="button">
                <button type="submit" class="btn btn-primary"> 
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            <div class="bottom-links">
                <p><a href="login.php">Already have an account?</a></p>
            </div>

        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> 

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>  

<script src="selectbox.js"></script>

</body>
</html>
