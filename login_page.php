<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'] ?? '';
    $password = $_POST['password'] ?? '';

    // Find the user in the database
    $stmt = $pdo->prepare('SELECT * FROM users WHERE matric = :matric');
    $stmt->execute(['matric' => $matric]);
    $user = $stmt->fetch();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Start the session
        session_start();
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

//        echo '<pre>';
//        var_dump($_SESSION);
//        echo '</pre>';
//
//        die();

        // Redirect to the home page
        header('Location: home_page.php');
        exit;
    } else {
        $error = 'Login failed. Please check your matric and password.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_register_page.css">
    <title>Login</title>
</head>
<body>

<div class="container">
    <form method="post" action="">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="form-group">
            <label for="matric">Matric:</label>
            <input type="text" name="matric" id="matric" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="button">Login</button>
    </form>
    <div class="switch">
        New user? <a href="register_page.php">Register</a>
    </div>
</div>

</body>
</html>
