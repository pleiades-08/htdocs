
<?php
require 'php-query/db.php';
session_start();

    if(!ISSET($_SESSION['user'])){
                header('location:index.php');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student_name = $_POST['student_name'];
            $research_type = $_POST['research_type'] ?? null;
                if (!$research_type) {
                    die("Please select a research type.");
                }
            $academic_year = $_POST['academic_year'];
            $semester = $_POST['semester'];
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
            $stmt = $pdo->prepare("INSERT INTO student_documents (student_name, file_name, academic_year, semester, research_type, research_progress) VALUES (?, ?, ?, ?)");
            $stmt->execute([$student_name, $fileName, $academic_year, $semester, $research_type, $research_progress]);
            echo "File uploaded and saved!";
            header('location: upload.php?success=1');
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
    <title>STUDENT | Upload</title>
</head>
<body>
    
<div class="navbar">
    <div class="logo">
        <img src="assets/img/kld-logo.png" alt="" class="kld-logo">
        <b><h2>IMACS STUDENT</h2></b>
    </div>
    <div class="nav-links">
      <a href="home.php" class="nav-link">Home</a>
      <a href="#" class="nav-link">Upload</a>
      <a href="documents.php" class="nav-link">Documents</a>
         <img src="assets/img/profile.png" alt="" class="nav-logo">
    </div>
</div>



<div class="content">

<div class="sidebar">
    <a href="home.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="documents.php">Documents</a>
    <a href="#">Upload</a>
    <a href="profile.php">Profile</a>
</div>

    <div class="content-page">
    <div class="col-md-3"></div>

    <div class="upload" style="text-align:center;">        
        <h2>Upload Title Proposal Documents</h2>
            <p>Student Name: <strong><?php echo htmlspecialchars($fetch['firstname'] . " " . $fetch['lastname']); ?></strong></p>
            <p>Accademic Year: <strong><?php echo htmlspecialchars($fetch['academic_year']); ?></strong></p>
            <p>Semester: <strong><?php echo htmlspecialchars($fetch['semester']); ?></strong></p>
            <p>Research Type: <strong>Title Proposal</strong></p>
        <form method="POST" enctype="multipart/form-data" style="text-align:center;">
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
            <input type="file" name="pdf_file" accept="application/pdf" required>
            <button type="submit" class="btn btn-primary">Upload PDF</button>
            <?php if (isset($_GET['success'])): ?>
            <p style="color: green; text-align:center;">File uploaded and saved successfully!</p>
        <?php endif; ?>
        </form>
    </div>
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names, titles..." style="margin: 10px; padding: 5px; width: 200px;">
        <table class="table table-striped table-hover mb-4" style="width: 90%; margin: 0 auto;" id="data_table">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">File Name</th>
                <th scope="col">Date Uploaded</th>
                <th scope="col">Research Type</th>
                <th scope="col">Research Progress</th>
                <th scope="col">Action</th>
            </tr>

            <?php if ($documents): ?>
                <?php foreach ($documents as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td><?= htmlspecialchars($row['file_name']) ?></td>
                        <td><?= $row['uploaded_at'] ?></td>
                        <td><?= $row['research_type'] ?></td>
                        <td><?= $row['research_progress'] ?></td>
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

<script>
function searchTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.querySelectorAll("#myTable tbody tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
}
</script>

</body>
</html>