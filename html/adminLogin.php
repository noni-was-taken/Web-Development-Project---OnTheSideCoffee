<?php
session_start();

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "admin";
$conn = "";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple credentials check (as per your request)
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php'); // Redirect to admin dashboard
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <title>Login</title>

    <link rel="stylesheet" href="../css/adminLogin.css">
</head>
<body>
    <div class="logo-container">
        <img src="../images/cafeLogo.png" alt="logo">
    </div>
    <div class="login-container">
        <h1>ADMIN</h1>

        <form method="POST" action="">
            <div class="form-table">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="form-table">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <input type="submit" value="Login" class="button">
        </form>
    </div>
</body>
</html>