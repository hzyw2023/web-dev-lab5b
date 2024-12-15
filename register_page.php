<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'] ?? '';
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Insert into the database
        $stmt = $pdo->prepare('INSERT INTO users (matric, name, password, role) VALUES (:matric, :name, :password, :role)');
        $stmt->execute([
            'matric' => $matric,
            'name' => $name,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        // Redirect to login page
        header('Location: login_page.php');
        exit;

    } catch (PDOException $e) {
        // Handle errors
        $error = 'Registration failed: ' . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_register_page.css">
    <title>Register</title>
</head>
<body>

<div class="container">
    <form method="post" action="">
        <h1>Register</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="form-group">
            <label for="matric">Matric:</label>
            <input type="text" name="matric" id="matric" required>
        </div>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="role">Role: </label>
            <select name="role" id="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>


        <button type="submit" class="button">Register</button>
    </form>
    <div class="switch">
        Already have an account? <a href="login_page.php">Login</a>
    </div>
</div>


</body>
</html>
