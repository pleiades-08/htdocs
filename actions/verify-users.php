<?php
require 'db.php';
if(!ISSET($_SESSION['user'])){
            echo "<script>alert('You must login first'); window.location='../../index.php';</script>";
    exit();
}
?>

