<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
session_start();

$fileName = $_POST['fileName'] ?? '';
$comments = $_POST['comments'] ?? '';
$suggestions = $_POST['suggestions'] ?? '';
$revisions = $_POST['required_revisions'] ?? '';
$chapter_no = $_POST['chapter_no'] ?? '';
$remarks = $_POST['remarks'] ?? '';
$document_id = $_POST['document_id'] ?? null;
$reviewer_id = $_POST['user_id'] ?? null;

$required = ['comments', 'suggestions', 'required_revisions', 'chapter_no', 'remarks'];
$missing = array_filter($required, function($field) {
    return !isset($_POST[$field]) || trim($_POST[$field]) === '';
});

if (!empty($missing)) {
    echo json_encode(['success' => false, 'error' => 'Please fill in all required fields.']);
    exit;
}


try {
    $stmt = $pdo->prepare("INSERT INTO document_feedback (
        document_id, 
        reviewer_id, 
        comments, 
        suggestions, 
        required_revisions, 
        chapter_no,
        remarks
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $document_id,
        $reviewer_id,
        htmlspecialchars($comments, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($suggestions, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($revisions, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($chapter_no, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($remarks, ENT_QUOTES, 'UTF-8')
    ]);

    echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    http_response_code(400); // For bad request
    exit;
}
?>
