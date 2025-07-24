<?php 

try {
    // Only attempt the document fetch if a valid team exists
    if (!$notOnTeam && isset($team['team_id'])) {
        $stmt = $pdo->prepare("SELECT * FROM documents WHERE uploader_id = ? AND team_id = ?");
        $stmt->execute([$id, $team['team_id']]);
        $documents = $stmt->fetchAll();

        if ($documents === false) {
            echo "Error fetching documents from the database.";
            $documents = [];
        }
    } else {
        $documents = []; // No team, so no documents to display
    }

    // The checks for $documents are already good here
    if (empty($documents)) {
        // No documents found, or no team, so display this message if applicable
    } else {
        // Documents were found, safely loop
    }

} catch (PDOException $e) {
    $error = $e->getMessage();
}


?>