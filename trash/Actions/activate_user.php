<?php
include('dbconnect.php');

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    // Get the user ID from the URL
    $user_id = (int) $_GET['user_id'];

    try {
        $sql = "UPDATE users SET status_ = 'Active' WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<script>
                alert("User Account Activated");
                window.location.href = "Manage_Account.php";
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
