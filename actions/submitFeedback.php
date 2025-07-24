<?php
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserController.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php'; // Add your database connection
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Validate required fields
$required = ['comments', 'suggestions', 'required_revisions', 'chapter_no', 'remarks', 'fileName'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => 'Missing required field: ' . $field]);
        exit;
    }
}

// Sanitize input
$comments = htmlspecialchars($_POST['comments'], ENT_QUOTES, 'UTF-8');
$suggestions = htmlspecialchars($_POST['suggestions'], ENT_QUOTES, 'UTF-8');
$revisions = htmlspecialchars($_POST['required_revisions'], ENT_QUOTES, 'UTF-8');
$chapter_no = htmlspecialchars($_POST['chapter_no'], ENT_QUOTES, 'UTF-8');
$remarks = htmlspecialchars($_POST['remarks'], ENT_QUOTES, 'UTF-8');
$fileName = $_POST['fileName'];

// Fetch document_id from fileName
$stmt = $pdo->prepare("SELECT document_id FROM documents WHERE document_name = ?");
$stmt->execute([$fileName]);
$document = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$document) {
    echo json_encode(['success' => false, 'message' => 'Document not found.']);
    exit;
}

$document_id = $document['document_id'];
$reviewer_id = $fetch['user_id']; // From session/fetchUserController


// Insert feedback
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
        $comments,
        $suggestions,
        $revisions,
        $chapter_no,
        $remarks
    ]);

    echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
