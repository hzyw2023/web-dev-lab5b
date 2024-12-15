<?php
require 'database.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_name'])) {
    header('Location: login_page.php');
    exit;
}

// Retrieve user info from the session
$user = [
    'name' => htmlspecialchars($_SESSION['user_name']),
    'role' => htmlspecialchars($_SESSION['user_role']),
];

$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="home_page.css">
    <title>Home</title>
</head>
<body>

<header>
    <div class="header-container">
        <div class="welcome-text">
            <p>Welcome <?= htmlspecialchars($user['name'])?></p>
        </div>
        <div class="nav-container">
            <div class="nav-item">
                <a href="home_page.php">Home</a>
            </div>
            <div class="nav-item">
                <a href="Logout.php">Logout</a>
            </div>
        </div>
    </div>
</header>

<main>
    <div class="main-container">
        <h1>User management table</h1>
        <table>
            <thead>
            <tr>
                <th>Matric No.</th>
                <th>Name</th>
                <th>Level</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['matric']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><a href="update_user_page.php?matric=<?= $user['matric'] ?>" >Update</a></td>
                    <td><a href="delete_user.php?matric=<?= $user['matric'] ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
    </div>
</main>

</body>
</html>