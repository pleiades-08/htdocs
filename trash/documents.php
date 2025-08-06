<?php
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchUserType.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchDocumentsController.php';
require $_SERVER['DOCUMENT_ROOT'] . './actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/searchDocuments.php';

$id = $_SESSION['user'];
try{

    $stmt = $pdo->prepare("SELECT d.*,CONCAT(u.first_name, ' ', u.last_name) AS uploader_full_name
        FROM 
            documents d
        JOIN 
            users u ON d.uploader_id = $id
        JOIN 
            teams 
        ORDER BY 
            d.created_at ASC");
        $stmt->execute();

        $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }    
    catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents with Uploader Names</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/sidebar.php'; ?>
    <br>
    <main>
        <div class="content-page">
            <h1 class="mb-4">Documents List</h1>
            
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Document ID</th>
                        <th>Document Name</th>
                        <th>Uploader</th>
                        <th>Upload Date</th>
                        <th>Status</th>
                        <th>Version</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                        <?php if ($documents): ?>
                            <?php foreach ($documents as $document): ?>
                            <tr>
                                <td><?= htmlspecialchars($document['document_id']) ?></td>
                                <td><?= htmlspecialchars($document['document_name']) ?></td>
                                <td><?= htmlspecialchars($document['uploader_full_name']) ?></td>
                                <td><?= date('M d, Y', strtotime($document['created_at'])) ?></td>
                                <td><?= htmlspecialchars($document['status']) ?></td>
                                <td><?= htmlspecialchars($document['version']) ?></td>
                                <td>
                                <a href="../../controllers/fetchLocationController.php?&progress=<?= urlencode($row['capstone_type']) ?>&file=<?= urlencode($row['file_name']) ?>&id=<?= urldecode($fetch['user_id'])?>" class="btn btn-sm btn-info">
                                    view
                                </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">No documents found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php exit(); ?>
        </div>
    </main>

</body>
</html>