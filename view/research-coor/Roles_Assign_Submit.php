<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = intval($_POST['team_id'] ?? 0);
    $chairperson = trim($_POST['chairperson'] ?? '');
    $major_disc = trim($_POST['major_disc'] ?? '');
    $minor_disc = trim($_POST['minor_disc'] ?? '');

    if ($team_id === 0 || empty($chairperson) || empty($major_disc) || empty($minor_disc)) {
        echo '<script>
            alert("All panel members are required.");
            window.history.back();
        </script>';
        exit;
    }

    try {
        $sql = "UPDATE tbl_teams 
                SET chairperson = :chairperson, 
                    major_disc = :major_disc, 
                    minor_disc = :minor_disc 
                WHERE team_id = :team_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':chairperson' => $chairperson,
            ':major_disc' => $major_disc,
            ':minor_disc' => $minor_disc,
            ':team_id' => $team_id
        ]);

        echo '<script>
            alert("Panel members assigned successfully.");
            window.location.href = "../View/Manage_Roles.php";
        </script>';

    } catch (PDOException $e) {
        $msg = addslashes($e->getMessage()); // Escape quotes for JS
        echo "<script>
            alert('Error updating: $msg');
            window.history.back();
        </script>";
    }
} else {
    echo "Invalid request.";
}
?>
