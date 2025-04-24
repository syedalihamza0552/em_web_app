<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #343a40 !important;
        }

        .navbar-brand {
            font-weight: 600;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem 1rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: white !important;
        }

        /* Fix for navbar buttons */
        .nav-link.btn-outline-light {
            border-radius: 20px;
            padding: 0.375rem 1.2rem;
            background-color: transparent;
        }

        .nav-link.btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
        }

        .home-container {
            max-width: 800px;
            margin: 5rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .welcome-message {
            background-color: #e3f2fd;
            border-radius: 8px;
            padding: 1.2rem;
            margin-top: 2rem;
            border-left: 4px solid #0d6efd;
        }

        .signup-message {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.2rem;
            margin-top: 2rem;
            border-left: 4px solid #6c757d;
        }

        h2 {
            color: #343a40;
            font-weight: 600;
        }

        .footer {
            text-align: center;
            margin-top: 3rem;
            padding: 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">MyApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light" href="./auth.php">Sign Up</a>
                        </li>
                    <?php else: ?>
                        <?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin']): ?>
                            <li class="nav-item me-2">
                                <a class="nav-link btn btn-outline-light" href="dashboard.php">Admin</a>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light" href="logout.php">Logout</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container home-container text-center">
        <h2 class="mb-4">Welcome to MyApp</h2>

        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <div class="welcome-message">
                <h4>Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</h4>
            </div>
        <?php else: ?>
            <div class="signup-message">
                <h4>New Here?</h4>
                <p class="mt-3 mb-2">Sign up to unlock all features and personalize your experience.</p>
                <a href="./auth.php" class="btn btn-primary mt-2">Create an Account</a>
            </div>
        <?php endif ?>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
            crossorigin="anonymous"></script>
</body>

</html>