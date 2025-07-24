<?php
ob_start();
require_once __DIR__ . '/../actions/db.php';

if (!isset($_GET['file']) || !isset($_GET['progress']) || !isset($_GET['name'])) {
    die("Missing parameters.");
}

$file = basename($_GET['file']);
$progress = $_GET['progress'];
$filepath = "../uploads/" . $file;
$fileName = $_GET['name'];


if (!file_exists($filepath)) {
    die("File not found.");
}

?>