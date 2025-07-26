<?php
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchUserController.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchDocumentsController.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/component.css">
    <title>IMACS FACULTY | Upload</title>
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/navbar.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/fsidebar.php'; ?>
    <br>


    <div class="content-page">
    <div class="col-md-3"></div>

    <div class="upload" style="text-align:center;">        
        <h2>Upload Title Proposal Documents</h2>
            <p>Student Name: <strong><?php echo htmlspecialchars($fetch['fname'] . " " . $fetch['lname']); ?></strong></p>
            <p>Student ID: <strong><?php echo htmlspecialchars($fetch['user_id']); ?></strong></p>
        <form method="POST" action="../../actions/upload-file.php" enctype="multipart/form-data" style="text-align:center;">
        <label for="">input your title</label>    
        <input type="text" name="title" required>
            <br>
            <label for="research">Choose a Capstone Type:</label>
                <select id="research_type" name="research_type">
                <option value="Web-Based">Web-Based</option>
                <option value="Augmented Reality">Augmented Reality</option>
                <option value="Artificial Intelligence">Artificial Intelligence</option>
                <option value="Arduino">Arduino</option>
                </select>
                <br>
            <input type="file" name="pdf_file" accept="application/pdf" required>
            <input type="hidden" name="research_progress" value="Title Proposal">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($fetch['user_id']); ?>">
            <input type="hidden" name="semester" value="1">
            <input type="hidden" name="academic_year" value="2025-2026">
            <input type="hidden" name="uploaded_by" value="<?php echo htmlspecialchars($fetch['fname'] . " " . $fetch['lname']); ?>">

            <button type="submit" class="btn btn-primary">Upload PDF</button>
            <?php if (isset($_GET['success'])): ?>
            <p style="color: green; text-align:center;">File uploaded and saved successfully!</p>
        <?php endif; ?>
        </form>
    </div>
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names, titles..." style="margin: 10px; padding: 5px; width: 200px;">
        <table class="table table-striped table-hover mb-4" style="width: 90%; margin: 0 auto;" id="data_table">
            <tr>
                <th scope="col">Uploade by</th>
                <th scope="col">Title</th>
                <th scope="col">Date Uploaded</th>
                <th scope="col">Academic Year</th>
                <th scope="col">Semester</th>
                <th scope="col">Research Type</th>
                <th scope="col">Version No.</th>
                <th scope="col">Action</th>
            </tr>

            <?php if ($documents): ?>
                <?php foreach ($documents as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['uploaded_by']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= $row['uploaded_at'] ?></td>
                        <td><?= $row['academic_year'] ?></td>
                        <td><?= $row['semester'] ?></td>
                        <td><?= $row['research_type'] ?></td>
                        <td><?= $row['version_num'] ?></td>
                        <td><a href="../../controllers/fetchLocationController.php?&progress=<?= urlencode($row['research_progress']) ?>&file=<?= urlencode($row['file_name']) ?>&id=<?= urldecode($fetch['user_id'])?>" class="btn btn-sm btn-info">View</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">No documents found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <?php
        exit();
        ?>
    </div>

    <script src="../../js/components.js"></script>
    
</body>
</html>