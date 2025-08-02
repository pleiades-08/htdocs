<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

if (isset($_POST["submit"])) {
    $role   = $_POST['user_type'];
    $school_id  = $_POST['school_id'];
    $kldemail  = $_POST['email'];
    $username  = $_POST['username'];
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fname     = $_POST['first_name'];
    $mname     = $_POST['middle_name'] ?? '';
    $lname     = $_POST['last_name'];
    $dept      = $_POST['dept'];

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO users 
            (school_id, 
            email, 
            username, 
            password, 
            first_name, 
            middle_name, 
            last_name, 
            dept, 
            user_type) 
            VALUES (:school_id, :email, :username, :password, :first_name, :middle_name, :last_name, :dept, :user_type)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':school_id', $school_id);
        $stmt->bindParam(':email', $kldemail);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':first_name', $fname);
        $stmt->bindParam(':middle_name', $mname);
        $stmt->bindParam(':last_name', $lname);
        $stmt->bindParam(':dept', $dept);
        $stmt->bindParam(':user_type', $role);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert user.");
        }

        $pdo->commit();

        echo '<script>
            alert("Data added successfully");
            window.location.href = "/admin-manage";
        </script>';
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>
