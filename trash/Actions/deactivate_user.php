<?php
include('dbconnect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $sql = "UPDATE tbl_accounts SET status_ = 'Inactive' WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<script>
                alert("User Account Deactivated");
                window.location.href = "Manage_Account.php";
            </script>';
            exit();
        } else {
            echo "Error: Failed to deactivate user.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "No valid user ID provided.";
}
?>
