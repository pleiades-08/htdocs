<?php 
require_once __DIR__ . '/../actions/db.php';
    
if ($fetch['user_type'] !== 'student') {
    header("Location: unauthorized.php");
    exit();
}

?>