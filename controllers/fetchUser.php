<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

$id = $_SESSION['user'];
        $sql = $pdo->prepare("SELECT * FROM `users` WHERE `user_id`='$id'");
        $sql->execute();
        $fetch = $sql->fetch();


?>