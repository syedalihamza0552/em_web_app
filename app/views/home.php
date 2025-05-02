<?php
session_start();
require_once('../models/Event.php');
require_once('../models/Category.php');
$category = Category::fetchAllCategories();
$categorys = $category['categories'];
$events = Event::fetchAllEvents();
$events = $events['events'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <style>
        body {
            background-color: rgb(40, 45, 49);
        }

        #filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }

        #filter-form .input-group {
            flex: 1 1 300px;
            max-width: 500px;
        }

        #filter-form .form-select {
            flex: 0 1 200px;
            max-width: 100%;
        }

        #filter-form .btn {
            flex: 0 1 auto;
            white-space: nowrap;
        }

        @media (max-width: 767.98px) {
            #filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            #filter-form .input-group,
            #filter-form .form-select,
            #filter-form .btn {
                flex: 1 1 100%;
                max-width: 100%;
            }

            #filter-form .input-group {
                margin-bottom: 0.5rem;
            }

            #filter-form .form-select {
                margin-bottom: 0.5rem;
            }
        }

        .home-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .event-date {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .event-category {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .event-location {
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .card {
            margin: 0 auto 1.5rem auto;
            width: 70%;
            position: relative;
        }

        #welcome {
            color: white;
        }

        #filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            width: 70%;
            margin: 0 auto 1.5rem auto;
        }

        #filter-form .input-group {
            flex: 1 1 300px;
            display: flex;
            width: 100%;
            flex-wrap: nowrap;
        }

        #filter-form .form-select {
            flex: 0 1 200px;
        }

        #filter-form .btn {
            flex: 0 1 auto;
            white-space: nowrap;
        }

        @media (max-width: 767.98px) {
            #filter-form {
                flex-direction: column;
                align-items: stretch;
                width: 85%;
            }

            #filter-form .input-group,
            #filter-form .form-select,
            #filter-form .btn {
                flex: 1 1 100%;
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        #search {
            width: 100%;
            max-width: 100%;
        }

        .input-group-text,
        .form-control {
            display: flex !important;
            flex: 0 0 auto;
        }

        .input-group>.input-group-text {
            white-space: nowrap;
        }
    </style>
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

    <div class="container home-container text-center">
        <h2 class="mb-4" id="welcome">Welcome to EM</h2>
    </div>

    <div class="container-fluid">
        <form id="filter-form" class="d-flex align-items-center mb-4">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-light border-0" id="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </span>
                <input type="text" id="search" class="form-control border-0 bg-light" placeholder="Search events..."
                    aria-label="Search events" aria-describedby="search-icon">
            </div>
            <select id="category" class="form-select shadow-sm">
                <option value="">All Categories</option>
                <?php foreach ($categorys as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['category']); ?>">
                        <?php echo htmlspecialchars($category['category']); ?>
                    </option>
                <?php endforeach; ?>


            </select>
            <button type="submit" class="btn btn-primary shadow-sm px-4">Apply Filters</button>
        </form>

        <?php if (count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                        <div class="event-date mb-2">
                            <?php echo date('F j, Y', strtotime($event['date'])); ?>
                        </div>
                        <div class="event-category mb-2">
                            <strong> Category:</strong> <?php echo htmlspecialchars($event['category']); ?>
                        </div>
                        <div class="event-location">
                            <?php echo htmlspecialchars($event['location']); ?>
                        </div>
                        <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                            <div class="action-btns position-absolute top-0 end-0 m-2">
                                <button type="button" class="btn btn-sm btn-danger me-1" id="delete"
                                    onclick="deleteEvent(<?php echo $event['id'] ?>)">Delete</button>
                                <a href="./editEvent.php?id=<?php echo $event['id']; ?>&title=<?php echo urlencode($event['title']); ?>&location=<?php echo urlencode($event['location']); ?>&date=<?php echo urlencode($event['date']); ?>&category=<?php echo urlencode($event['category']); ?>&description=<?php echo urlencode($event['description']); ?>"
                                    class="btn btn-sm btn-primary">Edit</a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <p class="card-text">No events available at the moment.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
        integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+"
        crossorigin="anonymous"></script>
    <script src="../../public/js/home.js"></script>
</body>

</html>