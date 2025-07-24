<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document']) && $team) {
    try {
        $file = $_FILES['document'];
        $description = $_POST['description'] ?? '';
        $file_name = basename($file['name']);
        $max_size = 300 * 1024 * 1024; // 300MB
        $allowed_types = ['application/pdf'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload error: " . $file['error']);
        }
        if ($file['size'] > $max_size) {
            throw new Exception("File size exceeds 300MB limit");
        }
        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception("Only PDF files are allowed");
        }

        // ======= VERSIONING SYSTEM ========
        $versionStmt = $pdo->prepare("
            SELECT version 
            FROM documents 
            WHERE team_id = ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $versionStmt->execute([$team['team_id']]);
        $lastVersion = $versionStmt->fetchColumn();

        if (!$lastVersion) {
            $newVersion = '1.0';
        } else {
            [$major, $minor] = explode('.', $lastVersion);
            $minor++;
            $newVersion = $major . '.' . $minor;
        }

        $uploadDir = __DIR__ . '/../uploads/';
        $filepath = $uploadDir . $file_name; // Corrected from undefined $fileName

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception("Failed to save file");
        }

        // Save to database
        $stmt = $pdo->prepare("
            INSERT INTO documents (
                team_id, 
                uploader_id, 
                document_name, 
                file_path, 
                file_type, 
                file_size, 
                version,
                status,
                file_name
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $team['team_id'],
            $id,
            htmlspecialchars($_POST['document_name'] ?? $team['capstone_title']),
            '/uploads/team_' . $team['team_id'] . '/' . $file_name,
            $file['type'],
            $file['size'],
            $newVersion,
            'Submitted',
            $file_name
        ]);

        $_SESSION['success'] = "File uploaded successfully (v$newVersion)";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
    