<?php
session_start();
if (!isset($_SESSION['logged_in']) && !isset($_SESSION['isAdmin']) && !$_SESSION['isAdmin']) {
    header("Location: home.php");
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="logout.php">Logout</a>
</body>

</html>