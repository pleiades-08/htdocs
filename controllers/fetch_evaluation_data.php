<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

header('Content-Type: application/json');
ob_clean();

$chapter_no = $_POST['selectedValue'] ?? '';
$documentId = $_POST['documentId'] ?? '';
$reviewerId = $_POST['reviewerId'] ?? ''; 

if (!$chapter_no || !$documentId || !$reviewerId) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$stmt = $pdo->prepare("SELECT comments, suggestions, required_revisions, remarks AS remarks
                        FROM document_feedback
                        WHERE document_id = :document_id
                        AND reviewer_id = :reviewer_id
                        AND chapter_no = :chapter_no
                    ");

$stmt->execute([
    ':document_id' => $documentId,
    ':reviewer_id' => $reviewerId,
    ':chapter_no' => $chapter_no
]);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($rows) {
    echo json_encode($rows);
} else {
    echo json_encode([]);
}

?>
