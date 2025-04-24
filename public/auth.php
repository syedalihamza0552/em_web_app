<?php
session_start();
if (isset($_SESSION[""])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auth</title>
    <link rel="stylesheet" href="./css/auth.css">
</head>

<body>
    <form id="login-form" method="POST">
        <h2 id="title">Welcome Back</h2>
        <p class="subtitle">Please login to your account</p>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required />

        <label for="username" id="username-l">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" />

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required />

        <button type="submit" name="login" id="s-btn">Login</button>

        <button type="button" name="change-type" id="change-type">Don't have an account? Sign up</button>
    </form>
    <script src="./js/auth.js"></script>
</body>

</html>