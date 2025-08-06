<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    try {
        if (!empty($username) && !empty($password)) {
            $sql = "SELECT * FROM `users` WHERE `username` = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$username]);

            if ($query->rowCount() > 0) {
                $fetch = $query->fetch();

                // Compare directly (plaintext version)
                if ($fetch['password'] === $password) {
                    if ($fetch['status_'] !== 'active') {
                        echo "<script>alert('This account is deactivated or deleted!'); window.location='../index.php';</script>";
                        exit();
                    }

                    $_SESSION['user'] = $fetch['user_id'];

                    $user_type = strtolower($fetch['user_type']);
                    // Redirect based on user type
                    if ($user_type === 'faculty' || $user_type === 'admin' || $user_type === 'coordinator') {
                        header("Location: /imacs-home");
                        exit();
                    } elseif ($user_type === 'student') {
                        header("Location: /student-home");
                        exit();
                    }
                    else {
                        echo "<script>alert('User type not recognized'); window.location='../index.php';</script>";
                        exit();
                    }
                }
            }

            // Username not found OR password is wrong
            echo "<script>alert('Incorrect username or password'); window.location='../index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Please enter both username and password'); window.location='../index.php';</script>";
            exit();
        }
    } catch (Exception $e) {
        echo "<script>alert('An error occurred.'); window.location='../index.php';</script>";
        exit();
    }
}
?>
