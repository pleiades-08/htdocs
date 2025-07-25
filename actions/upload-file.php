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

        $uploadDir = __DIR__ . '/../uploads/team_' . $team['team_id'] . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // create directory if it doesn't exist
        }
        
        $pathInfo = pathinfo($file_name);
        $versionedFileName = $pathInfo['filename'] . '_v' . $newVersion . '.' . $pathInfo['extension'];
        $filepath = $uploadDir . $versionedFileName;
        $documentName = htmlspecialchars($_POST['document_name'] ?? $team['capstone_title']) . ' (v' . $newVersion . ')';

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception("Failed to save file");
        }

        // Insert file metadata into the database
        $stmt = $pdo->prepare("
            INSERT INTO documents (
                team_id, 
                uploader_id, 
                document_name, 
                file_path, 
                file_type, 
                file_size, 
                version,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $team['team_id'],
            $id,
            $documentName,
            '/uploads/team_' . $team['team_id'] . '/' . $versionedFileName,
            $file['type'],
            $file['size'],
            $newVersion,
            'Submitted'
        ]);

        $_SESSION['success'] = "File uploaded successfully (v$newVersion)";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
    