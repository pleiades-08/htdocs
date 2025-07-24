<?php
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchUserController.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchDocumentsController.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <title>IMACS STUDENT | Upload</title>
</head>
<body>
    
<div class="navbar">
    <div class="logo">
        <img src="../../assets/img/kld-logo.png" alt="" class="kld-logo">
        <b><h2>IMACS STUDENT</h2></b>
    </div>
    <div class="nav-links">
      <a href="../../router/router.php?page=student-home" class="nav-link">Home</a>
      <a href="#" class="nav-link">Upload</a>
      <a href="../../router/router.php?page=student-documents" class="nav-link">Documents</a>
         <img src="../../assets/img/profile.png" alt="" class="nav-logo">
    </div>
</div>



<div class="content">

<div class="sidebar">
    <a href="../../router/router.php?page=student-home">Home</a>
    <a href="../../router/router.php?page=student-dashboard">Dashboard</a>
    <a href="../../router/router.php?page=student-documents">Documents</a>
    <a href="#">Upload</a>
    <a href="../../router/router.php?page=student-profile">Profile</a>
    <a href="../../router/router.php?page=logout">Logout</a>
</div>

    <div class="content-page">
    <div class="col-md-3"></div>

    <div class="upload">        
        <h2>Upload Title Proposal Documents</h2>
            <p>Student Name: <strong><?php echo htmlspecialchars($fetch['firstname'] . " " . $fetch['lastname']); ?></strong></p>
            <p>Academic Year: <strong><?php echo htmlspecialchars($fetch['academic_year']); ?></strong></p>
            <p>Semester: <strong><?php echo htmlspecialchars($fetch['semester']); ?></strong></p>
            <p>Research Type: <strong>Title Proposal</strong></p>
        <form method="POST" action="../../actions/upload-file.php" enctype="multipart/form-data" style="text-align:center;">
            <input type="hidden" name="research_progress" value="Title Proposal">
            <label for="research">Choose a Capstone Type:</label> 
                <select id="research_type" name="research_type">
                <option value="Web-Based">Web-Based</option>
                <option value="Augmented Reality">Augmented Reality</option>
                <option value="Artificial Intelligence">Artificial Intelligence</option>
                <option value="Arduino">Arduino</option>
                </select>
                <br>
            <input type="hidden" name="student_name" value="<?php echo htmlspecialchars($fetch['firstname'] . " " . $fetch['lastname']); ?>">
            <input type="hidden" name="semester" value="1">
            <input type="hidden" name="academic_year" value="2025-2026">
            
            <div class="upload-btn" style="align-items: center;">
                <input type="file" name="pdf_file" accept="application/pdf" required>
                <button type="submit" class="btn btn-primary">Upload PDF</button>
            </div>
            <?php if (isset($_GET['success'])): ?>
            <p style="color: green; text-align:center;">File uploaded and saved successfully!</p>
        <?php endif; ?>
        </form>
    </div>
        <div class="container">
            <div class="search">
                    <form method="GET" action="../../router/router.php">
                        <input type="hidden" name="page" value="imacs-documents">
                        <input type="text" name="search" class="search-bar" placeholder="Search by title, type..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            <table class="table table-striped table-hover mb-4" style="width: 100%;" id="data_table">
                <tr>
                    <th scope="col">Uploaded by</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date Uploaded</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Version No.</th>
                    <th scope="col">Action</th>
                </tr>

                <?php if ($documents): ?>
                    <?php foreach ($documents as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['uploaded_by']) ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= $row['uploaded_at'] ?></td>
                            <td><?= $row['research_status'] ?></td>
                            <td><?= $row['version_num'] ?></td>
                            <td><a href="../../router/router.php?page=imacs-view-pdf&file=<?=urlencode($row['file_name']) ?>&progress=<?= urlencode($row['research_progress']) ?>" class="btn btn-sm btn-info">View</a></td>

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
    </div>
</div>


</body>
</html>

<div class="content-page">
    <div class="col-md-3"></div>
        <h1 style="margin: 100px 50px 50px 50px;">Document Revision Tracking</h1>
        <div class="container">
            <div class="search">
                <form method="GET" action="../../router/router.php">
                    <input type="hidden" name="page" value="imacs-documents">
                    <input type="text" name="search" class="search-bar" placeholder="Search by title, type..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <table class="table table-striped table-hover mb-4" style="width: 100%;" id="data_table">
                <tr>
                    <th scope="col">Uploaded by</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date Uploaded</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Version No.</th>
                    <th scope="col">Action</th>
                </tr>

                <?php if ($documents): ?>
                    <?php foreach ($documents as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['uploaded_by']) ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= $row['uploaded_at'] ?></td>
                            <td><?= $row['research_status'] ?></td>
                            <td><?= $row['version_num'] ?></td>
                            <td><a href="../../router/router.php?page=imacs-view-pdf&file=<?=urlencode($row['file_name']) ?>&progress=<?= urlencode($row['research_progress']) ?>" class="btn btn-sm btn-info">View</a></td>

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
    </div>