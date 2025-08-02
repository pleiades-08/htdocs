<?php
require_once __DIR__ . '/../../../actions/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserController.php';

$current_user_statement = $pdo->query("SELECT * FROM users WHERE user_id = " . (int)$id); // Example, assuming $id is globally available and safe
$current_user = $current_user_statement->fetch(PDO::FETCH_ASSOC);
$is_adviser = ($current_user['user_type'] === 'faculty');


$query = "
    SELECT 
        t.team_id,
        t.team_name,
        t.capstone_title,
        t.capstone_type,
        CONCAT(a.first_name, ' ', a.last_name) AS adviser_name,
        GROUP_CONCAT(
            CONCAT(m.first_name, ' ', m.last_name, 
                    CASE WHEN tm.role = 'leader' THEN ' (Leader)' ELSE '' END)
            SEPARATOR ', '
        ) AS members
    FROM teams t
    JOIN users a ON t.adviser_id = a.user_id
    JOIN team_members tm ON t.team_id = tm.team_id
    JOIN users m ON tm.user_id = m.user_id
    " . ($is_adviser ? "WHERE t.adviser_id = ?" : "WHERE tm.user_id = ?") . "
    GROUP BY t.team_id
    ORDER BY t.team_id ASC
";

$stmt = $pdo->prepare($query);
$stmt->execute([$id]); // Assuming $id is already defined here.
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);



$teamd = isset($_GET['id']) ? $_GET['id'] : null;

$team_view = []; // Initialize to an empty array

// Only execute this query if team_id is provided in the URL
if ($teamd !== null) {
    $view_teams = "
        SELECT *,
        COALESCE(CONCAT(adv.first_name,' ', adv.last_name), 'No Adviser') AS adviser_name,
        COALESCE(CONCAT(tech.first_name,' ', tech.last_name), 'No Technical') AS technical_name,
        COALESCE(CONCAT(chair.first_name,' ', chair.last_name), 'No Chairperson') AS chairman_name,
        COALESCE(CONCAT(major.first_name,' ', major.last_name), 'No Major') AS major_name,
        COALESCE(CONCAT(minor.first_name,' ', minor.last_name), 'No Minor') AS minor_name,
        COALESCE(CONCAT(panel.first_name,' ', panel.last_name), 'No Panelist') AS panelist_name,
        GROUP_CONCAT(DISTINCT CONCAT(m.first_name, ' ', m.last_name) SEPARATOR ', ') AS members
        FROM teams t
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
        WHERE t.adviser_id = ? AND t.team_id = ?
        GROUP BY
            t.team_id
        ORDER BY t.team_id ASC
            ";

    $stmt_teams = $pdo->prepare($view_teams);
    // Corrected: Pass $id and $teamd as separate elements in the array
    $stmt_teams->execute([$id, $teamd]);
    $team_view = $stmt_teams->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/component.css">
    <title>IMACS FACULTY | WORKSPACE</title>
</head>
    <style>
        .table-container {
            margin: 30px auto;
            max-width: 1200px;
        }
        .team-title {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .leader {
            font-weight: bold;
            color: #0d6efd;
        }
        .custome-modal-width{
            max-width: 800px;
        }
    </style>
<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/navbar.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/fsidebar.php'; ?>
    <br>

    <div class="content-page">

    <!-- Modal -->
        <div class="modal fade  " id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
            <div class="modal-dialog custome-modal-width">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teamModalLabel">Team Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Capstone Title</label>
                        <input type="text" class="form-control" id="projectTitle" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Capstone Adviser</label>
                        <input type="text" class="form-control" id="adviserName" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Technical Adviser</label>
                        <input type="text" class="form-control" id="technicalName" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Chairperson</label>
                        <input type="text" class="form-control" id="chairName" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Major Discipline</label>
                        <input type="text" class="form-control" id="majorName" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Minor Discipline</label>
                        <input type="text" class="form-control" id="minorName" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Panelist</label>
                        <input type="text" class="form-control" id="panelistName" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="members" class="form-label">Members</label>
                        <textarea class="form-control" id="members" rows="3" readonly></textarea>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <h2 class="mb-4"><?= $is_adviser ? 'Your Advised Teams' : 'Your Capstone Team' ?></h2>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (empty($teams)): ?>
                <div class="alert alert-info">
                    <?= $is_adviser ? 'You are not currently advising any teams.' : 'You are not currently assigned to any team.' ?>
                </div>
            <?php else: ?>
                <table class="table table-striped table-hover mb-4" style="width: 100%;" id="data_table">
                    <thead class="table-dark">
                        <tr>
                            <th>Team ID</th>
                            <th>Team Name</th>
                            <th>Capstone Title</th>
                            <th>Type</th>
                            <th>Adviser</th>
                            <th>Team Members</th>
                            <?php if ($is_adviser): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teams as $team): ?>
                            <tr>
                                <td class="team-id"><?= htmlspecialchars($team['team_id']) ?></td>
                                <td class="team-title"><?= htmlspecialchars($team['team_name']) ?></td>
                                <td><?= htmlspecialchars($team['capstone_title']) ?></td>
                                <td><?= htmlspecialchars($team['capstone_type']) ?></td>
                                <td><?= htmlspecialchars($team['adviser_name']) ?></td>
                                <td>
                                    <?php 
                                    $members = explode(', ', $team['members']);
                                    foreach ($members as $member) {
                                        if (strpos($member, '(Leader)') !== false) {
                                            echo '<span class="leader">' . htmlspecialchars($member) . '</span>,<br>';
                                        } else {
                                            echo htmlspecialchars($member) . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <?php if ($is_adviser): ?>
                                    <td>
                                        <a href="edit_team.php?id=<?= htmlspecialchars($team['team_id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="#" 
                                            class="btn btn-sm btn-info open-modal-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#teamModal"
                                            data-team-id="<?= htmlspecialchars($team['team_id']) ?>">
                                            View
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php if ($is_adviser): ?>
                <div class="mt-4">
                    <a href="imacs-add_teams" class="btn btn-success">Create New Team</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/view_team.js"></script>

</body>
</html>