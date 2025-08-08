<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

$id = $_SESSION['user'] ?? null;

// If no user ID in session
if (!$id) {
        session_destroy();
        header("Location: /index.php");
        exit;
}

$sql = $pdo->prepare("SELECT * FROM `users` WHERE `user_id` = ?");
$sql->execute([$id]);
$side = $sql->fetch(PDO::FETCH_ASSOC);

// If no matching user found
if (!$side) {
        session_destroy();
        header("Location: /index.php");
        exit;
}

// $side now contains the logged-in user's data
?>
