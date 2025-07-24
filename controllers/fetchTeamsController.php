<?php 

$stmt = $pdo->prepare("
    SELECT t.team_id, t.team_name, t.capstone_title, t.capstone_type
    FROM team_members tm
    JOIN teams t ON tm.team_id = t.team_id
    WHERE tm.user_id = ?
");
$stmt->execute([$id]);
$team = $stmt->fetch();

if (!$team) {
    $error = 'Your are not currently on a team';
}

if (!isset($team) || $team === false || empty($team)) {
    $team = []; 
    $notOnTeam = true;
} else {
    $notOnTeam = false;
}

?>