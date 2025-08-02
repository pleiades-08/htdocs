<?php
include '../dbconnect.php';

if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing user_id']);
    exit;
}

$user_id = (int) $_GET['user_id'];

$stmt = $conn->prepare("SELECT * FROM tbl_accounts WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode($user);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
}
?>