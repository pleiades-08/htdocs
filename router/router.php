<?php
declare(strict_types=1);
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
session_start();


$page = $_GET['page'] ?? 'imacs-home';

$routes = [

    //admin router
    'admin-home' => '../view/admin/admin-home.php',
    'admin-dashboard' => '../view/admin/admin-dashboard.php',
    'admin-documents' => '../view/admin/admin-documents.php',
    'admin-profile' => '../view/admin/admin-profile.php',
    'admin-manage' => '../view/admin/manage-account.php',
    
    //research coordinator router
    'research-coor-home' => '../view/research-coor/research-coor-home.php',
    'research-coor-dashboard' => '../view/research-coor/research-coor-dashboard.php',
    'research-coor-documents' => '../view/research-coor/research-coor-documents.php',
    'research-coor-profile' => '../view/research-coor/research-coor-profile.php',
    'research-coor-manage_roles' => '../view/research-coor/manage_roles.php',

    //Faculty router
    'imacs-home' => '../view/imacs/imacs-home.php',
    'imacs-profile' => '../view/imacs/profile.php',
    'imacs-documents' => '../view/imacs/documents.php', 
    'imacs-dashboard' => '../view/imacs/dashboard.php',
    'imacs-upload' => '../view/imacs/upload.php',
    'imacs-title_proposal' => '../view/imacs/eval_page/title_proposal.php',
    'imacs-capstone_1' => '../view/imacs/eval_page/capstone_1.php',
    'imacs-capstone_2' => '../view/imacs/eval_page/capstone_2.php',
    'imacs-workspace' => '../view/imacs/advisory_page/workspace.php',
    'imacs-capstone_teams' => '../view/imacs/advisory_page/capstone_teams.php',
    'imacs-capstone_titles' => '../view/imacs/advisory_page/capstone_titles.php',
    'imacs-capstone_eval' => '../view/imacs/advisory_page/capstone_eval.php',
    'imacs-add_teams' => '../view/imacs/advisory_page/add_teams.php',

    //student router
    'student-home' => '../view/student/student-home.php',
    'student-dashboard' => '../view/student/dashboard.php',
    'student-documents' => '../view/student/documents.php',
    'student-no_team' => '../view/student/no_team.php',
    'student-profile' => '../view/student/profile.php',
    'student-upload' => '../view/student/teams/upload.php',
    'student-title_proposal' => '../view/student/eval_page/title_proposal.php', 
    'student-capstone_1' => '../view/student/eval_page/capstone_1.php', 
    'student-capstone_2' => '../view/student/eval_page/capstone_2.php', 
    'student-capstone_teams' => '../view/student/teams/capstone_teams.php', 
    'student-request_schedule' => '../view/student/teams/request_schedule.php', 


    'logout' => $_SERVER['DOCUMENT_ROOT'] . '/actions/logout.php',

    'error404' => $_SERVER['DOCUMENT_ROOT'] . '/error404.php'
];

// ✅ Load valid page or 404
if (array_key_exists($page, $routes)) {
    require $routes[$page];
} else {
    http_response_code(404);
    header('Location: error404');
}
