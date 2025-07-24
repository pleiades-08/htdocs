<?php
// Get the document data
$stmt = $pdo->prepare("SELECT document_id FROM documents WHERE document_name = ?");
$stmt->execute([$fileName]);
$document = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$document) {
    die("Document not found");
}

$document_id = $document['document_id'];
$reviewer_id = $fetch['user_id'];

?>