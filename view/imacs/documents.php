<?php
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchDocumentsController.php';
require $_SERVER['DOCUMENT_ROOT'] . './actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/searchDocuments.php';

try{

        $stmt = $pdo->prepare("SELECT 
                d.*,
                CONCAT(u.first_name, ' ', u.last_name) AS uploader_full_name,
                t.capstone_type
            FROM 
                documents d
            JOIN 
                users u ON d.uploader_id = u.user_id
            JOIN 
                teams t ON d.team_id = t.team_id
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
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>IMACS | Documents</title>
</head>
<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/sidebar.php'; ?>
    <br>

    <main class="flex-grow-1 p-4">
        <div class="content-page">
            <h1 style="margin: 100px 50px 50px 50px;">Document Revision Tracking</h1>
                <div class="search">
                    <form method="GET" action="../../router/router.php">
                        <input type="hidden" name="page" value="imacs-documents">
                        <input type="text" name="search" class="search-bar" placeholder="Search by title, type..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tr>
                            <th scope="col">Uploaded by</th>
                            <th scope="col">Team ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Date Uploaded</th>
                            <th scope="col">Capstone Progress</th>
                            <th scope="col">Version No.</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                            <?php if ($documents): ?>
                                <?php foreach ($documents as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['uploader_full_name']) ?></td>
                                        <td><?= htmlspecialchars($row['team_id']) ?></td>
                                        <td><?= htmlspecialchars($row['document_name']) ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                        <td><?= $row['capstone_type'] ?></td>
                                        <td><?= $row['version'] ?></td>
                                        <td><?= $row['status'] ?></td>
                                        <td>
                                        <a href="../../controllers/fetchLocationController.php?&progress=<?= urlencode($row['capstone_type']) ?>&file=<?= htmlspecialchars(urlencode($row['file_path'])) ?>&id=<?= urldecode($fetch['user_id'])?> &name=<?= urldecode($row['document_name'])?>&td=<?= urldecode($row['team_id'])?>" class="btn btn-sm btn-info">
                                            View
                                        </a></td>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align:center;">No documents found.</td>
                            </tr>
                        <?php endif; ?>
                    </table>

                </div>
                
                <?php
                exit();
                ?>
        </div>
    </main>


</body>
</html>