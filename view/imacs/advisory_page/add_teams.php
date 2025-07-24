<?php
require_once __DIR__ . '/../../../actions/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

// Fetch current adviser using your existing method
$id = $_SESSION['user'];
$sql = $pdo->prepare("SELECT * FROM `users` WHERE `user_id` = ?");
$sql->execute([$id]);
$fetch = $sql->fetch();

$adviser_id = $fetch['user_id'];
$adviser_name = $fetch['first_name'] . " " . $fetch['middle_name'] . " " . $fetch['last_name'];

// Fetch all students not already in a team
$students = [];
$stmt = $pdo->prepare("
    SELECT u.user_id, CONCAT(u.first_name, ' ', u.last_name) AS full_name 
    FROM users u
    LEFT JOIN team_members tm ON u.user_id = tm.user_id
    WHERE u.user_type = 'student' AND (tm.user_id IS NULL OR tm.user_id NOT IN (
        SELECT user_id FROM team_members
    ))
    ORDER BY u.last_name, u.first_name
");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $team_name = $_POST['team_name'];
        $capstone_title = $_POST['capstone_title'];
        $capstone_type = $_POST['capstone_type'];
        $members = array_filter([
            $_POST['member1'],
            $_POST['member2'],
            $_POST['member3'],
            $_POST['member4'],
            $_POST['member5']
        ]);
        
        // Validate inputs
        if (empty($team_name) || empty($capstone_title) || empty($members)) {
            throw new Exception("All required fields must be filled");
        }
        
        if (count($members) < 2) {
            throw new Exception("A team must have at least 2 members");
        }
        
        // Check if any member is already in a team
        $placeholders = implode(',', array_fill(0, count($members), '?'));
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM team_members 
            WHERE user_id IN ($placeholders)
        ");
        $stmt->execute($members);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("One or more selected students are already in another team");
        }
        
        // Start transaction
        $pdo->beginTransaction();
        
        // Create the team
        $stmt = $pdo->prepare("
            INSERT INTO teams (team_name, capstone_title, capstone_type, adviser_id)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$team_name, $capstone_title, $capstone_type, $adviser_id]);
        $team_id = $pdo->lastInsertId();
        
        // Add members
        $stmt = $pdo->prepare("
            INSERT INTO team_members (team_id, user_id, role)
            VALUES (?, ?, ?)
        ");
        
        // First member is leader
        $stmt->execute([$team_id, $members[0], 'leader']);
        
        // Other members are regular members
        for ($i = 1; $i < count($members); $i++) {
            $stmt->execute([$team_id, $members[$i], 'member']);
        }
        
        $pdo->commit();
        
        $_SESSION['success'] = "Team created successfully!";
        header("Location: imacs-capstone_teams");
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error = "Please Change your Team name or Tittle";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
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
    </style>
<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/navbar.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/fsidebar.php'; ?>
    <br>


    <div class="content-page"> 
            <div class="col-md-10">
                <div class="container mt-5">
        <h1 class="mb-4">Create New Capstone Team</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" id="teamForm">
            <div class="mb-3">
                <label for="team_name" class="form-label">Team Name</label>
                <input type="text" class="form-control" id="team_name" name="team_name" required>
            </div>
            
            <div class="mb-3">
                <label for="capstone_title" class="form-label">Capstone Title</label>
                <input type="text" class="form-control" id="capstone_title" name="capstone_title" required>
            </div>
            
            <div class="mb-3">
                <label for="capstone_type" class="form-label">Capstone Type</label>
                <select class="form-select" id="capstone_type" name="capstone_type" required>
                    <option value="Title Proposal">Title Proposal</option>
                    <option value="Capstone 1">Capstone 1</option>
                    <option value="Capstone 2">Capstone 2</option>
                </select>
            </div>
            
            <input type="hidden" name="adviser" value="<?= htmlspecialchars($adviser_name) ?>">
            
            <h4 class="mt-4">Team Members</h4>
            <p>Select at least 2 members. The first member will be the team leader.</p>
            
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="member-select">
                    <label for="member<?= $i ?>" class="form-label">
                        Member <?= $i ?><?= $i === 1 ? ' (Leader)' : ($i <= 2 ? ' (Required)' : ' (Optional)') ?>
                    </label>
                    <select class="form-select member-select" id="member<?= $i ?>" name="member<?= $i ?>" <?= $i <= 2 ? 'required' : '' ?>>
                        <option value="">-- Select Student --</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= htmlspecialchars($student['user_id']) ?>">
                                <?= htmlspecialchars($student['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endfor; ?>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Create Team</button>
                <a href="/imacs-capstone_teams" class="btn btn-secondary">Cancel</a>
            </div>
                </form>
    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const memberSelects = document.querySelectorAll('select.member-select');
            
            function updateDropdownOptions() {
                const selectedValues = Array.from(memberSelects)
                    .map(select => select.value)
                    .filter(value => value !== "");
                
                memberSelects.forEach(currentSelect => {
                    const currentValue = currentSelect.value;
                    Array.from(currentSelect.options).forEach(option => {
                        option.disabled = option.value !== "" && 
                                         option.value !== currentValue && 
                                         selectedValues.includes(option.value);
                    });
                });
            }
            
            memberSelects.forEach(select => {
                select.addEventListener('change', updateDropdownOptions);
            });
            
            updateDropdownOptions();
        });
    </script>

    <script src="../../js/components.js"></script>
</body>
</html>