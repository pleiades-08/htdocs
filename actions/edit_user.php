<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {
    $user_id  = (int) $_POST['user_id'];
    $school_id = $_POST['school_id'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'] ?? '';
    $last_name = $_POST['last_name'];
    $dept = $_POST['dept'];

    try {
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET 
                        username = :username,
                        password = :password,
                        email = :email,
                        first_name = :first_name,
                        middle_name = :middle_name,
                        last_name = :last_name,
                        school_id = :school_id,
                        dept = :dept
                    WHERE user_id = :user_id";
            $params = [
                ':user_id' => $user_id,
                ':username' => $username,
                ':password' => $hashed,
                ':email' => $email,
                ':first_name' => $first_name,
                ':middle_name' => $middle_name,
                ':last_name' => $last_name,
                ':school_id' => $school_id,
                ':dept' => $dept
            ];
        } else {
            $sql = "UPDATE users SET 
                        username = :username,
                        email = :email,
                        first_name = :first_name,
                        middle_name = :middle_name,
                        last_name = :last_name,
                        school_id = :school_id,
                        dept = :dept
                    WHERE user_id = :user_id";
            $params = [
                ':user_id' => $user_id,
                ':username' => $username,
                ':email' => $email,
                ':first_name' => $first_name,
                ':middle_name' => $middle_name,
                ':last_name' => $last_name,
                ':school_id' => $school_id,
                ':dept' => $dept
            ];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo '<script>
            alert("Account updated successfully.");
            window.location.href = "/admin-manage";
        </script>';
        exit;

    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
        exit;
    }
}
?>
