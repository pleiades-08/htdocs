<?php
ob_start();
require_once __DIR__ . '/../actions/db.php';


if (!isset($_GET['id']) || !isset($_GET['td'])) {
    die("Missing parameters.; window.location='../../index.php';");
}

// get the user role 
$id = $_GET['id'];
        $sql = $pdo->prepare("SELECT user_type FROM `users` WHERE `user_id`='$id'");
        $sql->execute();
        $fetch = $sql->fetch();

$role = $fetch['user_type'];

$team_id = $_GET['td'];

$sql_docs = $pdo->prepare("SELECT 
                                t.team_id,
                                t.team_name,
                                d.document_id,
                                d.document_name,
                                d.file_path,
                                t.capstone_type
                            FROM teams AS t
                            JOIN documents AS d 
                                ON t.team_id = d.team_id
                            WHERE t.team_id = ?");
$sql_docs->execute([$team_id]);
$doc = $sql_docs->fetch(PDO::FETCH_ASSOC); // fetch one row

$progress = $doc['capstone_type'] ?? '';
$file = $doc['file_path'] ?? '';
$fileName = $doc['document_name'] ?? '';




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
if ($role === 'faculty' || $role === 'admin' || $role === 'coordinator') {
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