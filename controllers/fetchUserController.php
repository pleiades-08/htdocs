<?php
require_once __DIR__ . '/../actions/db.php';

$id = $_SESSION['user'];
        $sql = $pdo->prepare("SELECT * FROM `users` WHERE `user_id`='$id'");
        $sql->execute();
        $fetch = $sql->fetch();

?>
