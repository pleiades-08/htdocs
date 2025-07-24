<?php
include('dbconnect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $sql = "UPDATE tbl_accounts SET status_ = 'Active' WHERE id = :id";
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
