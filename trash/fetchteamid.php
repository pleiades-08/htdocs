<?php
include '../dbconnect.php';

$teams = [];
$team_ids = [];

try {
    // Fetch all teams
    $team_stmt = $conn->query("SELECT * FROM tbl_teams");
    $team_rows = $team_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($team_rows as $row) {
        $teams[$row['team_id']] = $row;
        $team_ids[] = $row['team_id'];
    }

    $members_by_team = [];

    if (!empty($team_ids)) {
        // Prepare placeholders for team_ids
        $placeholders = implode(',', array_fill(0, count($team_ids), '?'));

        $member_sql = "
            SELECT tm.team_id, CONCAT(a.fname, ' ', a.mname, ' ', a.lname) AS fullname
            FROM tbl_team_members tm
            JOIN tbl_accounts a ON tm.student_id = a.user_id
            WHERE tm.team_id IN ($placeholders)
            ORDER BY tm.team_id
        ";
        $member_stmt = $conn->prepare($member_sql);
        $member_stmt->execute($team_ids);
        $member_rows = $member_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($member_rows as $member) {
            $members_by_team[$member['team_id']][] = $member['fullname'];
        }
    } else {
        echo "No teams found.";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>