<?php
require_once __DIR__ . '/../../../actions/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserType.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchTeamsController.php'; // This is where $team is likely populated
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/validateTeamController.php'; // This is where $team is likely populated
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/upload-file.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device=width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>IMACS STUDENTS | Upload</title>
</head>
<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/sidebar.php'; ?>
    <br>
    <main class="flex-grow-1 p-4">
        <div class="content-page">
            <div class="col-md-3"></div>

            <div class="container upload-container">
                <h2 class="mb-4 mt-4">Upload Capstone Documents</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <div class="card mb-5">
                    <div class="card-header">
                        <h5><?php if (!empty($team) && isset($team['team_name'])): ?>
                                Team: <?= htmlspecialchars($team['team_name']) ?>
                            <?php else: ?>
                                Team: You are not on a team
                            <?php endif; ?>
                        </h5>

                        <p><?php if (!empty($team) && isset($team['capstone_type'])): ?>
                                Type: <?= htmlspecialchars($team['capstone_type']) ?>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </p>
                    </div>
                    
                <div class="card-body">
                    <?php if (!empty($team) && isset($team['team_name'])): // This check is already good! ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="" class="form-label">Document Title: </label>
                                <h5 style="padding: 8px;"><?php if (!empty($team) && isset($team['capstone_title'])): ?>
                                        <?= htmlspecialchars($team['capstone_title']) ?>
                                    <?php else: ?>
                                        Team: You are not on a team
                                    <?php endif; ?>
                                    <input type="hidden" name="document_name" value="<?= htmlspecialchars($team['capstone_title']) ?>">
                                </h5>
                            </div>
                            
                            
                            <div class="mb-3">
                                <label for="document" class="form-label">Select File (PDF or Word)</label>
                                <input class="form-control" type="file" id="document" name="document" accept=".pdf,.doc,.docx" required>
                                <div class="form-text">Maximum file size: 300MB</div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Upload Document</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            You must be part of a team to upload documents.
                        </div>
                    <?php endif; ?>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
<script src="../../js/components.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
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