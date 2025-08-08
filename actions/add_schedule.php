<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

if (!isset($_POST['team_id'])) {
    die("Not logged in or team ID not set.");
}

if (!isset($_GET['date']) || !isset($_POST['timestart'])) {
    die("Missing required data.");
}

$team_id = $_POST['team_id'];
$def_date = $_GET['date']; // match SQL placeholder
$def_time = $_POST['timestart']; // match SQL placeholder

try {
    $stmt = $pdo->prepare("
        INSERT INTO request_dates (team_id, def_date, def_time) 
        VALUES (:team_id, :def_date, :def_time)
    ");
    $stmt->bindParam(':team_id', $team_id);
    $stmt->bindParam(':def_date', $def_date);
    $stmt->bindParam(':def_time', $def_time);
    $stmt->execute();

    echo '<script>
            alert("Request Added");
            window.location.href = "/student-request_schedule";
        </script>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
