<?php 
require_once __DIR__ . '/../actions/db.php';

    $stmt = $pdo->query("SELECT * FROM documents ORDER BY created_at DESC");

    $documents = $stmt->fetchAll();

?>