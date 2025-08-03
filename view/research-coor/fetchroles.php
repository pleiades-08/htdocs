<?php
include '../dbconnect.php';

try {
    // Fetch all faculty members
    $faculty_stmt = $conn->prepare("
        SELECT user_id, CONCAT(fname, ' ', mname, ' ', lname) AS fullname 
        FROM tbl_accounts 
        WHERE role = 'Faculty'
    ");
    $faculty_stmt->execute();
    $faculty_rows = $faculty_stmt->fetchAll(PDO::FETCH_ASSOC);

    $faculty = [];
    foreach ($faculty_rows as $row) {
        $faculty[$row['user_id']] = $row['fullname'];
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
