<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

if (!isset($_SESSION['team_id'])) {
    die("Not logged in or team ID not set.");
}

if (!isset($_GET['date']) || !isset($_POST['timestart'])) {
    die("Missing required data.");
}

$date = $_GET['date'];
$time = $_POST['timestart'];
$team_id = $_SESSION['team_id'];

try {
    $stmt = $conn->prepare("INSERT INTO tbl_reqdef (defense_date, defense_time, team_id) VALUES (:date, :time, :team_id)");
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':team_id', $team_id);
    $stmt->execute();

    echo "Defense request successfully added!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
