<?php 
require_once __DIR__ . '/../actions/db.php';

$search = $_GET['search'] ?? '';
$search = trim($search);

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM documents 
        WHERE title LIKE :search 

        ORDER BY created_at DESC");
        $stmt->execute(['search' => "%$search%"]);

} else {

    $stmt = $pdo->query("SELECT * FROM documents ORDER BY created_at DESC");
}

$documents = $stmt->fetchAll();

?>