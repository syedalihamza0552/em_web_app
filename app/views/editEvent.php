<?php
session_start();
require_once('../models/Event.php');
if (!isset($_SESSION['logged_in']) && !isset($_SESSION['isAdmin']) && !$_SESSION['isAdmin']) {
    header("Location: auth.php");
    exit;
}
require_once('../models/Category.php');
$category = Category::fetchAllCategories();
$categorys = $category['categories'];

$id = $_GET['id'];
$title = $_GET['title'];
$location = $_GET['location'];
$date = $_GET['date'];
$category = $_GET['category'];
$description = $_GET['description'];


$formatted_date = '';
if (!empty($date)) {
    $date_obj = strtotime($date);
    if ($date_obj !== false) {
        $formatted_date = date('Y-m-d', $date_obj);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editEvent'])) {
    $ntitle = $_POST['title'];
    $nlocation = $_POST['location'];
    $ndate = $_POST['date'];
    $ncategory = $_POST['category'];
    $ndescription = $_POST['description'];
    $res = Event::editEvent($ntitle, $ndescription, $ndate, $nlocation, $ncategory, $id);
    if ($res['success']) {
        header("Location: " . $res['redirect']);
    } else {
        $error = $res['error'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Event (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/form.css">

    <style>
        h2 {
            color: white;
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
    <div class="container">
        <h2 class="mt-4 mb-4">Edit Event</h2>

        <form id="frm" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Title"
                    value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control" id="location" placeholder="Location"
                    value="<?php echo htmlspecialchars($location ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="date"
                    value="<?php echo htmlspecialchars($formatted_date ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" class="form-select" id="category" required>
                    <option value="" disabled>Select a category</option>
                    <?php foreach ($categorys as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['category']); ?>">
                            <?php echo htmlspecialchars($category['category']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3"
                    required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id ?? ''); ?>">
            <button type="submit" class="btn btn-primary" name="editEvent">Update Event</button>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
        integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+"
        crossorigin="anonymous"></script>
</body>

</html>