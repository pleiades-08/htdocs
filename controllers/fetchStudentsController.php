<?php
/*
ob_start();
require_once __DIR__ . '/../actions/db.php';

try {
    $sql = "
                SELECT user_id, CONCAT(fname, ' ', mname, ' ', lname) AS fullname
        FROM tbl_accounts
        WHERE role = 'Student'
          AND status_ = 'Active'
          AND user_id NOT IN (SELECT student_id FROM tbl_team_members)
    ";

    $stmt = $pdo->query($sql);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($students);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>*/