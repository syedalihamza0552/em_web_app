<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !isset($_SESSION['logged_in'])) {
    header("Location: auth.php");
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <h2>Welcome, <?php echo $_SESSION['email']; ?>!</h2>
    <a href="logout.php">Logout</a>
</body>

</html>