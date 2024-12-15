<?php
session_start();
require 'database.php';

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $stmt = $pdo->prepare('DELETE FROM users WHERE matric = :matric');
    $stmt->execute(['matric' => $matric]);
}

header('Location: home_page.php');
exit;
?>
