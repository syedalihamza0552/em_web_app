<?php
session_start();
require_once('../models/User.php');
if (isset($_SESSION["logged_in"])) {
    header("Location: dashboard.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["login"])) {
    $email = $_POST['email'];
    $Pass = $_POST['password'];
    $res = User::loginUser($email, $Pass);
    if ($res['success']) {
        header("Location: " . $res['redirect']);
    } else {
        $error = $res['error'];
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/auth.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">EM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item me-2">
                        <a class="nav-link btn btn-outline-light" href="dashboard.php">Admin</a>
                    </li>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light" href="logout.php">Logout</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="auth-page">
        <form id="login-form" method="POST">
            <h2 id="title">Welcome Back</h2>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required />
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required />
            <button type="submit" name="login" id="s-btn">Login</button>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
        integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+"
        crossorigin="anonymous"></script>
    <!-- <script src="../../public/js/auth.js"></script> -->
</body>

</html>