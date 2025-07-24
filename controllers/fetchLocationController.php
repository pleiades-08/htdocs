<?php
ob_start();
require_once __DIR__ . '/../actions/db.php';


if (!isset($_GET['id']) || !isset($_GET['progress'])
    || !isset($_GET['name']) || !isset($_GET['td'])) {
    die("Missing parameters.; window.location='../../index.php';");
}


$id = $_GET['id'];
        $sql = $pdo->prepare("SELECT user_type FROM `users` WHERE `user_id`='$id'");
        $sql->execute();
        $fetch = $sql->fetch();

$team_id = $_GET['td'];    
$role = $fetch['user_type'] ?? '';
$progress = $_GET['progress'] ?? '';
$file = $_GET['file'] ?? '';
$fileName = $_GET['name'] ?? '';

// Ensure required parameters are present
if (empty($progress) || empty($file)) {
    if($role === 'faculty'){
    echo "<script>alert('Missing FILE'); 
        window.location='/imacs-documents'</script>"; 
        exit();   
    }
    if($role === 'students'){
    echo "<script>alert('Missing FILE'); 
        window.location='/student-documents'</script>";    
        exit();
    }
}

// Define base route path by role
$routePrefix = '';
if ($role === 'faculty') {
    $routePrefix = 'imacs';
} elseif ($role === 'student') {
    $routePrefix = 'student';
} else {
    echo "User role is: " . htmlspecialchars($role);
    echo "<script>alert('Invalid user role');</script>";
    exit();
}

// Map progress to page suffix
$pageMap = [
    'Title Proposal' => 'title_proposal',
    'Capstone 1'     => 'capstone_1',
    'Capstone 2'     => 'capstone_2',
];

// Route if progress matches
if (isset($pageMap[$progress])) { //student-capstone_1
    $page = $routePrefix . '-' . $pageMap[$progress];
    header("Location: /$page?progress=" . urlencode($progress) . "&file=" . urldecode($file) . 
            "&name=" . urlencode($fileName) . "&td=" . urlencode($team_id)); 
    exit();
} else {
    echo "<script>alert('Invalid progress value');</script>";
    exit();
}
?>