<?php
include('../dbconnect.php');

if (isset($_POST["submit"])) {
    $role   = $_POST['role'];
    $school_id  = $_POST['school_id'];
    $kldemail  = $_POST['kldemail'];
    $username  = $_POST['username'];
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fname     = $_POST['fname'];
    $mname     = $_POST['mname'] ?? '';
    $lname     = $_POST['lname'];
    $dept      = $_POST['dept'];

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO tbl_accounts 
            (school_id, kldemail, username, password, fname, mname, lname, dept, role) 
            VALUES (:school_id, :kldemail, :username, :password, :fname, :mname, :lname, :dept, :role)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':school_id', $school_id);
        $stmt->bindParam(':kldemail', $kldemail);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':mname', $mname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':dept', $dept);
        $stmt->bindParam(':role', $role);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert user.");
        }

        $conn->commit();

        echo '<script>
            alert("Data added successfully");
            window.location.href = "../View/Manage_Account.php";
        </script>';
        exit;

    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>
