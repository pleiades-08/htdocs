<?php
include '../dbconnect.php';

$data = json_decode(file_get_contents("php://input"), true);
$dates = $data['dates'] ?? [];

if (empty($dates)) {
    echo "No dates provided.";
    exit;
}

try {
    $stmt = $conn->prepare("INSERT IGNORE INTO tbl_defdates (defense_date) VALUES (?)");
    foreach ($dates as $date) {
        $stmt->execute([$date]);
    }
    echo "Dates saved successfully.";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}
?>