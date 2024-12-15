<?php
session_start();
require 'database.php';

if (!isset($_GET['matric'])) {
    header('Location: home_page.php');
    exit;
}

$matric = $_GET['matric'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE matric = :matric');
$stmt->execute(['matric' => $matric]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? '';

    try {
        $updateStmt = $pdo->prepare('UPDATE users SET name = :name, role = :role, matric = :matric WHERE matric = :matric');
        $updateStmt->execute([
            'name' => $name,
            'role' => $role,
            'matric' => $matric
        ]);

        header('Location: home_page.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Update failed: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="login_register_page.css">
</head>
<body>
<div class="container">
    <form method="post">
        <h1>Update User</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="form-group">
            <label for="matric">Matric Number:</label>
            <input type="text" name="matric" id="matric" value="<?= htmlspecialchars($user['matric']) ?>" required>
        </div>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Access Level: </label>
            <select name="role" id="role" value="<?= htmlspecialchars($user['role']) ?>" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="button">Update</button>
    </form>
</div>
</body>
</html>
