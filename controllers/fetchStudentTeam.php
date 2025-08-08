<?php

$id = $_SESSION['user'] ?? 0;

$isInTeam = false;

if ($id > 0) {
        $sql = $pdo->prepare("SELECT * FROM team_members WHERE user_id = ?");
        $sql->execute([$id]);
        $fetch = $sql->fetch();

        if ($fetch) {
                $isInTeam = true;
                $teamId = $fetch['team_id']; 
        }
}
?>
