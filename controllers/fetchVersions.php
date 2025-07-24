<?php

$versions = [];
$team = $_GET['td'] ?? null;
try {
    if ($team) {
        $stmt = $pdo->prepare("SELECT document_name, version, created_at FROM documents WHERE team_id = ? ORDER BY version ASC");
        $stmt->execute([$team]);
        $versions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>


    