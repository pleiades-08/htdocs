<?php
require_once 'db.php';


$adviser = $_POST['adviser'];
$title = $_POST['title'];
$role = $_POST['role'];
$members = [
    $_POST['member1'],
    $_POST['member2'],
    $_POST['member3'],
    $_POST['member4'],
    $_POST['member5']
];

try {
    // Start transaction
    $pdo->beginTransaction();

    // Insert into tbl_teams
    $stmt = $pdo->prepare("INSERT INTO tbl_teams (title, role, adviser) VALUES (?, ?, ?)");
    $stmt->execute([$title, $role, $adviser]);
    $team_id = $pdo->lastInsertId();

    // Insert each member into tbl_team_members
    $stmt_member = $pdo->prepare("INSERT INTO tbl_team_members (team_id, student_id, student_name) VALUES (?, ?, ?)");
    foreach ($members as $student_id) {
        if (!empty($student_id)) {
            $stmt_member->execute([$team_id, $student_id, $student_name]);
        }
    }

    // Commit transaction
    $pdo->commit();

    // Redirect after success
    echo "<script>alert('Successfully Added'); window.location='/imacs-add_teams';</script>";
    exit();
} catch (PDOException $e) {
    // Roll back on error
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
