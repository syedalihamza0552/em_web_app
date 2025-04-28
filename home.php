<?php
session_start();
require_once('../models/Event.php');
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
        .home-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .event-cards {
            margin-top: 2rem;
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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
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
        <h2 class="mb-4">Welcome to EM</h2>
    </div>



    <div class="container-fluid">
        <form id="filter-form"
            onsubmit="event.preventDefault(); filterEvents(document.getElementById('category').value, document.getElementById('search').value)">
            <input type="text" id="search" placeholder="Search events...">
            <select id="category">
                <option value="">All Categories</option>
                <option value="Birthday">Birthday</option>
                <option value="Wedding">Wedding</option>
                <option value="Funeral">Funeral</option>
                <option value="Meet Up">Meet Up</option>
                <option value="Other">Other</option>

            </select>
            <button type="submit">Apply Filters</button>
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
                            <?php echo htmlspecialchars($event['category']); ?>
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

    <script src="../../public/js/home.js"></script>
</body>

</html>