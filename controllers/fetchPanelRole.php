<?php
try {
    // Fetch all faculty, coordinator, and dean users
    $faculty_stmt = $pdo->prepare("
        SELECT user_type, user_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS fullname 
        FROM users
        WHERE user_type IN ('faculty', 'coordinator', 'dean')
    ");
    $faculty_stmt->execute();
    $faculty_rows = $faculty_stmt->fetchAll(PDO::FETCH_ASSOC);

    $faculty = [];
    foreach ($faculty_rows as $row) {
        // Format: [user_id] => "ID - Full Name"
        $faculty[$row['user_id']] = $row['user_id'] . " - " . $row['fullname'] . "  (" . $row['user_type'] . ")";
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
