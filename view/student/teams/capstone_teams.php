<?php
// Ensure db.php is included, as $pdo is used.
// If verify-users.php already includes it, you might not need this line.
// Otherwise, add: require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

// Initialize variables to safe defaults
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

// fetchDocumentsController.php is likely redundant now as document fetching is integrated above.
// If it contains other essential logic, keep it, but ensure no redundant/conflicting queries.
// require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchDocumentsController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents with Uploader Names</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/component.css">
</head>
<style>

</style>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/navbar.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/sidebar.php'; ?>
    <br>
    <div class="content-page">
        <div class="container-t">
            <div class="table-title">Team Details</div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if ($user_is_on_team): ?>
                <!-- Example Row 1 -->
                <div class="table-row">
                    <div class="header-cell">Title:</div>
                    <div class="data-cell">
                        <?= htmlspecialchars($teamData['capstone_title']) ?>
                    </div>
                </div>

                <!-- Example Row 2 -->
                <div class="table-row">
                    <div class="header-cell">Adviser:</div>
                    <div class="data-cell"><?= htmlspecialchars($teamData['adviser_name']) ?></div>
                </div>

                <!-- Example Row 3 -->
                <div class="table-row">
                    <div class="header-cell">Technical:</div>
                    <div class="data-cell"><?= htmlspecialchars($teamData['technical_name']) ?></div>
                </div>

                <!-- Example Row 4 -->
                <div class="table-row">
                    <div class="header-cell">Chairman:</div>
                    <div class="data-cell"><?= htmlspecialchars($teamData['chairman_name']) ?></div>
                </div>

                <!-- Example Row 5 -->
                <div class="table-row">
                    <div class="header-cell">Major Discipline:</div>
                    <div class="data-cell"><?= htmlspecialchars($teamData['major_name']) ?></div>
                </div>

                <!-- Example Row 6 -->
                <div class="table-row">
                    <div class="header-cell">Minor Discipline:</div>
                    <div class="data-cell"><?= htmlspecialchars($teamData['minor_name']) ?></div>
                </div>

                <!-- Example Row 7 -->
                <div class="table-row">
                    <div class="header-cell">Panelist:</div>
                    <div class="data-cell"><?= htmlspecialchars($teamData['panelist_name']) ?></div>
                </div>

                <!-- Example Row for Team Members (using a list inside data cell) -->
                <div class="table-row">
                    <div class="header-cell">Team Members:</div>
                    <div class="data-cell">
                        <ul class="team-members-list">
                        <?php 
                        // Ensure 'members' key exists and is not null before exploding
                        $members = !empty($teamData['members']) ? explode(', ', $teamData['members']) : [];
                        if (!empty($members)) {
                            foreach ($members as $member) {
                                echo '<li>' . htmlspecialchars(trim($member)) . '</li>';
                            }
                        } else {
                            echo '<li>No members found for this team.</li>';
                        }
                        ?>
                        </ul>
                    </div>
                </div>

                <!-- Example Row 8 (if you need another single piece of data) -->
                <div class="table-row">
                    <div class="header-cell">Project Status:</div>
                    <div class="data-cell">In Progress</div>
                </div>

                <div class="table-title">Previously added Documents</div>
                <?php if (empty($documents)): ?>
                    <div class="alert alert-info">No documents uploaded yet.</div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($documents as $doc): ?>
                            <div class="list-group-item document-card mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="file-icon">
                                            <?php if (strpos($doc['file_type'], 'pdf') !== false): ?>
                                                📄
                                            <?php elseif (strpos($doc['file_type'], 'word') !== false): ?>
                                                📝
                                            <?php else: ?>
                                                📁
                                            <?php endif; ?>
                                        </span>
                                        <div>
                                            <h6><?= htmlspecialchars($doc['document_name']) ?></h6>
                                            <small class="text-muted">
                                                Uploaded: <?= date('M d, Y h:i A', strtotime($doc['created_at'])) ?>
                                                | Size: <?= round($doc['file_size'] / 1024 / 1024, 2) ?>MB
                                                | Status: <span class="badge bg-<?= 
                                                    $doc['status'] === 'Approved' ? 'success' : 
                                                    ($doc['status'] === 'Rejected' ? 'danger' : 'warning') 
                                                ?>"><?= $doc['status'] ?></span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Message displayed if user is not on a team -->
                <div class="alert alert-info mt-4">
                    You are not currently assigned to any team. Please contact your administrator to be added to a team.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../../js/components.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>