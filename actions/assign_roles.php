<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = intval($_POST['team_id'] ?? 0);
    $technical_id = intval($_POST['technical_name'] ?? 0);
    $chairperson_id = intval($_POST['chairman_name'] ?? 0);
    $major_id = intval($_POST['major_name'] ?? 0);
    $minor_id = intval($_POST['minor_name'] ?? 0);
    $panelist_id = intval($_POST['panelist_name'] ?? 0);

    if ($team_id === 0 || $technical_id === 0 || $chairperson_id === 0 || $major_id === 0 
        || $minor_id === 0 || $panelist_id === 0) {
        echo '<script>
            alert("All panel members are required.");
            window.history.back();
        </script>';
        exit;
    }

    try {
        $sql = "UPDATE teams 
                    SET technical_id = :technical,
                        chairperson_id = :chairperson,
                        major_id = :major,
                        minor_id = :minor,
                        panelist_id = :panelist
                    WHERE team_id = :team_id";


        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':technical'   => $technical_id,
            ':chairperson' => $chairperson_id,
            ':major'       => $major_id,
            ':minor'       => $minor_id,
            ':panelist'    => $panelist_id,
            ':team_id'     => $team_id
        ]);

        echo '<script>
            alert("Panel members assigned successfully.");
            window.location.href = "/research-coor-manage_roles";
        </script>';

    } catch (PDOException $e) {
        $msg = addslashes($e->getMessage());
        echo "<script>
            alert('Error updating: $msg');
            window.history.back();
        </script>";
    }
} else {
    echo "Invalid request.";
}
?>
