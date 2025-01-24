<?php
session_start();
include 'dbconnect.php'; // Include your database connection file

// Initialize error messages
$username_error = "";
$password_error = "";

// Clear error messages after they've been displayed
if (isset($_SESSION['username_error'])) {
    $username_error = $_SESSION['username_error'];
    unset($_SESSION['username_error']);
}

if (isset($_SESSION['password_error'])) {
    $password_error = $_SESSION['password_error'];
    unset($_SESSION['password_error']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            $_SESSION['username'] = $row['username']; // Store username in session
            $_SESSION['role'] = $row['role']; // Store user role in session

            // If 'Stay signed in' is checked, set cookies
            if (isset($_POST['check']) && $_POST['check'] == 'stay') {
                setcookie('user_id', $row['id'], time() + (30 * 24 * 60 * 60), '/');
                setcookie('username', $row['username'], time() + (30 * 24 * 60 * 60), '/');
            }

            // Redirect based on the role
            if ($row['role'] == 'seller') {
                header("Location: index.php");
            } else if ($row['role'] == 'costumer') {
                header("Location: index.php");
            } else {
                // Default redirection in case of unexpected role value
                header("Location: login.php");
            }
            exit();
        } else {
            $_SESSION['password_error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['username_error'] = "User not found.";
    }

    // Redirect back to the same page to display error messages
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" type="image/x-icon" href="gaming/images/gaming%20universe.png">
    <link rel="stylesheet" href="style/styles.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>

<body>
    <div class="logo-container">
        <img class="logo" style="width:150px; height:150px;" src="gaming/images/gaming%20universe.png"/>
    </div>

    <div class="container" style="height: 40rem;">
        <h1>Sign In</h1>
        <div id="form">
            <form action="" method="POST">


            <!-- Error message for username -->
            <?php if (isset($username_error) && !empty($username_error)): ?>
                <p style="font-family: 'Maven Pro', sans-serif; color: red; padding-bottom: 5px;"><?php echo $username_error; ?></p>
            <?php endif; ?>
          
                <div class="input-container input-value">
                    <input type="text" name="username" required />
                    <label for="username">Username</label>
                </div>


                <?php if (isset($password_error) && !empty($password_error)): ?>
                <p style="font-family: 'Maven Pro', sans-serif; color: red; padding-bottom: 5px;"><?php echo $password_error; ?></p>
            <?php endif; ?>


                <div class="input-container input-value">
                    <input type="password" name="password" required />
                    <label for="password">Password</label>
                </div>

                <div class="checkbox">
                </div>

                <div class="button">
                    <button class="btn" type="submit"><i class="fas fa-arrow-right"></i></button>
                </div>

                <div class="bottom-links">
                    <p><a href="signup.php">Create account</a></p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
