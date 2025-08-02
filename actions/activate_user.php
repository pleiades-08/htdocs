<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    // Get the user ID from the URL
    $user_id = (int) $_GET['user_id'];

    try {
        $sql = "UPDATE users SET status_ = 'active' WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<script>
                alert("User Account Activated");
                window.location.href = "/admin-manage";
            </script>';
            exit();
        } else {
            echo "Error updating status.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "No valid user ID provided.";
}
?>
