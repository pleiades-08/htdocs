<?php
require_once __DIR__ . '/../../../actions/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

// Fetch current user
$user_id = $_SESSION['user'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Check if user is a student
if ($user['user_type'] !== 'student') {
    header("Location: unauthorized.php");
    exit();
}

// Get student's team information
$stmt = $pdo->prepare("
    SELECT t.team_id, t.team_name, t.capstone_title, t.capstone_type
    FROM team_members tm
    JOIN teams t ON tm.team_id = t.team_id
    WHERE tm.user_id = ?
");
$stmt->execute([$user_id]);
$team = $stmt->fetch();

if (!$team) {
    die("You are not assigned to any team.");
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    try {
        // File validation
        $file = $_FILES['document'];
        $max_size = 20 * 1024 * 1024; // 20MB
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload error: " . $file['error']);
        }
        
        if ($file['size'] > $max_size) {
            throw new Exception("File size exceeds 20MB limit");
        }
        
        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception("Only PDF and Word documents are allowed");
        }
        
        // Create upload directory if not exists
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/team_' . $team['team_id'];
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'capstone_' . $team['capstone_type'] . '_' . date('Ymd_His') . '.' . $file_ext;
        $filepath = $upload_dir . '/' . $filename;
        
        // Move uploaded file
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
                description,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 'Submitted')
        ");
        
        $stmt->execute([
            $team['team_id'],
            $user_id,
            htmlspecialchars($_POST['document_name']),
            '/uploads/team_' . $team['team_id'] . '/' . $filename,
            $file['type'],
            $file['size'],
            htmlspecialchars($_POST['description'])
        ]);
        
        $_SESSION['success'] = "File uploaded successfully!";
        header("Location: upload.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get previously uploaded documents
$stmt = $pdo->prepare("
    SELECT * FROM documents 
    WHERE team_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$team['team_id']]);
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .upload-container {
            max-width: 800px;
            margin: 30px auto;
        }
        .file-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .document-card {
            transition: all 0.3s;
        }
        .document-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>
    
    <div class="container upload-container">
        <h2 class="mb-4">Upload Capstone Documents</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <div class="card mb-5">
            <div class="card-header">
                <h5>Team: <?= htmlspecialchars($team['team_name']) ?></h5>
                <p>Capstone Title: <?= htmlspecialchars($team['capstone_title']) ?></p>
                <p>Current Phase: <?= htmlspecialchars($team['capstone_type']) ?></p>
            </div>
            
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="document_name" class="form-label">Document Title</label>
                        <input type="text" class="form-control" id="document_name" name="document_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="document" class="form-label">Select File (PDF or Word)</label>
                        <input class="form-control" type="file" id="document" name="document" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Maximum file size: 20MB</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Upload Document</button>
                </form>
            </div>
        </div>
        
        <h4 class="mb-3">Previously Uploaded Documents</h4>
        
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
                                    <?php if ($doc['description']): ?>
                                        <p class="mt-1 mb-0"><?= htmlspecialchars($doc['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?= htmlspecialchars($doc['file_path']) ?>" class="btn btn-sm btn-outline-primary" download>Download</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Client-side file validation
        document.getElementById('document').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 20 * 1024 * 1024; // 20MB
            const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            
            if (file.size > maxSize) {
                alert('File size exceeds 20MB limit');
                e.target.value = '';
            }
            
            if (!allowedTypes.includes(file.type)) {
                alert('Only PDF and Word documents are allowed');
                e.target.value = '';
            }
        });
    </script>
</body>
</html>