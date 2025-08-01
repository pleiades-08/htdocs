<?php 
require_once __DIR__ . '/../actions/db.php';

$search = $_GET['search'] ?? '';
$search = trim($search);

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM users 
        WHERE (username LIKE :search OR email LIKE :search OR first_name LIKE :search OR last_name LIKE :search) 
        ORDER BY created_at ASC");
        $stmt->execute(['search' => "%$search%"]);

} else {

    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
}

$users = $stmt->fetchAll();

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
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>