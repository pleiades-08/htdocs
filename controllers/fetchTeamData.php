<?php

$teamData = []; // Will hold detailed team information
$documents = []; // Will hold documents for the team
$error = null;   // For general errors
$user_is_on_team = false; // Flag to check if the user belongs to a team

try {
    $user_id = $_SESSION['user']; // Assuming $_SESSION['user'] holds the user ID

    // 1. Check if the user is part of any team
    $stmt_team_member = $pdo->prepare("SELECT team_id FROM `team_members` WHERE `user_id` = ?");
    $stmt_team_member->execute([$user_id]);
    $userTeam = $stmt_team_member->fetch(PDO::FETCH_ASSOC);

    if ($userTeam) {
        $user_is_on_team = true;
        $teamid = $userTeam['team_id'];

        // 2. If user is on a team, fetch detailed team data
        $query = "
            SELECT t.*,
                COALESCE(CONCAT(adv.first_name,' ', adv.last_name), 'No Adviser') AS adviser_name,
                COALESCE(CONCAT(tech.first_name,' ', tech.last_name), 'No Technical') AS technical_name,
                COALESCE(CONCAT(chair.first_name,' ', chair.last_name), 'No Chairperson') AS chairman_name,
                COALESCE(CONCAT(major.first_name,' ', major.last_name), 'No Major') AS major_name,
                COALESCE(CONCAT(minor.first_name,' ', minor.last_name), 'No Minor') AS minor_name,
                COALESCE(CONCAT(panel.first_name,' ', panel.last_name), 'No Panelist') AS panelist_name,
                GROUP_CONCAT(DISTINCT CONCAT(m.first_name, ' ', m.last_name) SEPARATOR ', ') AS members
            FROM
                `teams` t
            LEFT JOIN
                `users` adv ON t.adviser_id = adv.user_id
            LEFT JOIN
                `users` tech ON t.technical_id = tech.user_id
            LEFT JOIN
                `users` chair ON t.chairperson_id = chair.user_id
            LEFT JOIN
                `users` major ON t.major_id = major.user_id
            LEFT JOIN
                `users` minor ON t.minor_id = minor.user_id
            LEFT JOIN
                `users` panel ON t.panelist_id = panel.user_id
            LEFT JOIN
                `team_members` tm ON t.team_id = tm.team_id
            LEFT JOIN
                `users` m ON tm.user_id = m.user_id
            WHERE
                t.team_id = ?
            GROUP BY
                t.team_id
        ";
        $stmt_team_data = $pdo->prepare($query);
        $stmt_team_data->execute([$teamid]);
        $results = $stmt_team_data->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            $teamData = $results[0];

            // 3. If team data is found, fetch documents for this team
            $stmt_docs = $pdo->prepare("SELECT * FROM documents WHERE uploader_id = ? AND team_id = ?");
            $stmt_docs->execute([$user_id, $teamData['team_id']]);
            $documents = $stmt_docs->fetchAll(PDO::FETCH_ASSOC);

            // The previous checks for $documents === false are less necessary here
            // if PDO is configured to throw exceptions, but keeping empty() check is good.
            // if ($documents === false) { /* handle error if fetchAll returns false */ }
        } else {
            // This case means user is in team_members but no full team data found, which is an inconsistency
            $error = "Detailed team data not found for your assigned team. Please contact support.";
            $user_is_on_team = false; // Treat as if not on a team for display purposes
        }
    } else {
        // User is not part of any team
        $error = "You are not currently part of any team.";
        // $teamData and $documents will remain empty as initialized
    }

} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $user_is_on_team = false; // Ensure UI reflects no team if a DB error occurs
}

?>