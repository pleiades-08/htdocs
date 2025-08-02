<?php
// Database connection
require_once __DIR__ . '/../actions/db.php';

header('Content-Type: application/json');
try {
    $activesql = "SELECT user_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS fullname, user_type, dept, status_ 
                    FROM users 
                    WHERE status_ = 'active'";
    $active_stmt = $pdo->query($activesql);
    $active_accounts = $active_stmt->fetchAll(PDO::FETCH_ASSOC);


    $inactivesql = "SELECT user_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS fullname, user_type, dept, status_ 
                    FROM users 
                    WHERE status_ = 'inactive'";

    $inactive_stmt = $pdo->query($inactivesql);
    $inactive_accounts = $inactive_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'active' => $active_accounts,
        'inactive' => $inactive_accounts
    ]);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>