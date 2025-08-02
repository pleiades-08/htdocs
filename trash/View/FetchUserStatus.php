<?php
// Database connection
include '../dbconnect.php';

try {
    $activesql = "SELECT user_id, CONCAT(fname, ' ', mname, ' ', lname) AS fullname, role, dept, status_ 
                    FROM tbl_accounts 
                    WHERE status_ = 'Active'";
    $active_stmt = $conn->query($activesql);
    $active_accounts = $active_stmt->fetchAll(PDO::FETCH_ASSOC);

    $inactivesql = "SELECT user_id, CONCAT(fname, ' ', mname, ' ', lname) AS fullname, role, dept, status_ 
                    FROM tbl_accounts 
                    WHERE status_ = 'Inactive'";
    $inactive_stmt = $conn->query($inactivesql);
    $inactive_accounts = $inactive_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>