<?php    
    try{        
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
        GROUP BY
            t.team_id
    ";
    $stmt_team_data = $pdo->prepare([$query]);
    $results = $stmt_team_data->fetchAll(PDO::FETCH_ASSOC);

    
    if (!empty($results)) {
        $teamData = $results[0];
        $user_is_on_team = true;

    } else {
        $error = "Detailed team data not found for your assigned team. Please contact support.";
        $user_is_on_team = false; 
    }

    } catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $user_is_on_team = false; 
    }
?>
