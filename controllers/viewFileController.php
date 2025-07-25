<?php
ob_start();
require_once __DIR__ . '/../actions/db.php';

if (!isset($_GET['file']) || !isset($_GET['progress']) || !isset($_GET['name'])) {
    die("Missing parameters.");
}

$progress = $_GET['progress'];
$file_path = $_GET['file'];
$fileName = $_GET['name'];


?>