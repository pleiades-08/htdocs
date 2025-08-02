<?php
include('../dbconnect.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {
    $user_id       = (int) $_POST['user_id'];
    $school_id = $_POST['school_id'];
    $kldemail = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $fname    = $_POST['first_name'];
    $mname    = $_POST['middle_name'] ?? '';
    $lname    = $_POST['last_name'];
    $dept     = $_POST['dept'];

    try {
        if (!empty($password)) {
            // Password provided — update it
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET 
                        school_id = :school_id,
                        kldemail = :kldemail,
                        username = :username,
                        password = :password,
                        fname = :fname,
                        mname = :mname,
                        lname = :lname,
                        dept = :dept
                    WHERE user_id = :user_id";
            $params = [
                ':school_id' => $school_id,
                ':email' => $kldemail,
                ':username' => $username,
                ':password' => $hashed,
                ':first_name'    => $fname,
                ':middle_name'    => $mname,
                ':last_name'    => $lname,
                ':dept'     => $dept,
                ':user_id'       => $user_id
            ];
        } else {
            // No password provided — exclude it
            $sql = "UPDATE users SET 
                        school_id = :school_id,
                        kldemail = :kldemail,
                        username = :username,
                        fname = :fname,
                        mname = :mname,
                        lname = :lname,
                        dept = :dept
                    WHERE user_id = :user_id";
            $params = [
                ':school_id' => $school_id,
                ':email' => $kldemail,
                ':username' => $username,
                ':first_name'    => $fname,
                ':middle_name'    => $mname,
                ':last_name'    => $lname,
                ':dept'     => $dept,
                ':user_id'       => $user_id
            ];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        echo '<script>
            alert("Account updated successfully.");
            window.location.href = "../View/Manage_Account.php";
        </script>';
        exit;

    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
        exit;
    }
}
?>
