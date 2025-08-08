<?php
// Get the document data
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUser.php';

$stmt = $pdo->prepare("SELECT document_id FROM documents WHERE document_name = ?");
$stmt->execute([$fileName]);
$document = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$document) {
    die("Document not found");
}

$document_id = $document['document_id'];
$reviewer_id = $fetch['user_id'];

?>