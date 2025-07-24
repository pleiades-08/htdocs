<?php
require 'php-query/db.php';
session_start();

    if(!ISSET($_SESSION['user'])){
                header('location:index.php');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student_name = $_POST['student_name'];
            $file = $_FILES['pdf_file'];

        if ($file['type'] == 'application/pdf') {
            
            $fileName = basename($file['name']);
            $uploadDir = 'uploads/';
            $targetPath = $uploadDir . $fileName;

            // Create uploads folder if not exist
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }


        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Save to database using PDO
            $stmt = $pdo->prepare("INSERT INTO student_documents (student_name, file_name) VALUES (?, ?)");
            $stmt->execute([$student_name, $fileName]);
            echo "File uploaded and saved!";
            header('location: home.php?success=1');
            exit();
            } else {
                echo "File upload failed!";
            }
        } else {
            echo "Only PDF files are allowed!";
        }
    }

    //FETCH USER INFO
     $id = $_SESSION['user'];
                    $sql = $pdo->prepare("SELECT * FROM `member` WHERE `mem_id`='$id'");
                    $sql->execute();
                    $fetch = $sql->fetch();
   
    
// Fetch uploaded documents
$stmt = $pdo->query("SELECT * FROM student_documents ORDER BY uploaded_at ASC");
$documents = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>STUDENT | Documents</title>
</head>
<body>
    
<div class="navbar">
    <div class="logo">
        <img src="assets/img/kld-logo.png" alt="" class="kld-logo">
        <b><h2>IMACS STUDENT</h2></b>
    </div>
    <div class="nav-links">
      <a href="home.php" class="nav-link">Home</a>
      <a href="upload.php" class="nav-link">Upload</a>
      <a href="#" class="nav-link">Documents</a>
        <img src="assets/img/profile.png" alt="" class="nav-logo">
    </div>
</div>



<div class="content">

<div class="sidebar">
    <a href="home.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="#">Documents</a>
    <a href="Upload.php">upload</a>
    <a href="profile.php">Profile</a>
</div>

    <div class="content-page">
    <div class="col-md-3"></div>
        <h1 style="margin: 100px 50px 50px 50px;">Document Revision Tracking</h1>

        <table class="table table-striped table-hover mb-4" style="width: 98%; margin: 0 auto;">
            <tr>
                <th scope="col">Uploaded By</th>
                <th scope="col">File Name</th>
                <th scope="col">Date Uploaded</th>
                <th scope="col">Academic Year</th>
                <th scope="col">Semester</th>
                <th scope="col">Research Type</th>
                <th scope="col">Research Progress</th>
                <th scope="col">Action</th>
            </tr>

            <?php if ($documents): ?>
                <?php foreach ($documents as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td><?= htmlspecialchars($row['file_name']) ?></td>
                        <td><?= $row['uploaded_at'] ?></td>
                        <td><?= htmlspecialchars($row['academic_year']) ?></td>
                        <td><?= htmlspecialchars($row['semester']) ?></td>
                        <td><?= htmlspecialchars($row['research_type']) ?></td>
                        <td><?= htmlspecialchars($row['research_progress']) ?></td>
                        <td><a href="view-pdf.php?file=<?= urlencode($row['file_name']) ?>&progress=<?= urlencode($row['research_progress']) ?>" class="btn btn-sm btn-info">View</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No documents found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <?php
        exit();
        ?>
    </div>
</div>
</body>
</html>