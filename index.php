<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: events.php");
    exit;
} else {
    header("Location: ../public/auth.php");
    exit;
}
?>
