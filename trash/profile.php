
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>STUDENT | Profile</title>
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
      <a href="documents.php" class="nav-link">Documents</a>
        <img src="assets/img/profile.png" alt="" class="nav-logo">
    </div>
</div>



<div class="content">

<div class="sidebar">
    <a href="home.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="documents.php">Documents</a>
    <a href="upload.php">upload</a>
    <a href="#">Profile</a>
</div>

    <div class="content-page">
        <h1 style="margin: 100px 50px 50px 50px;">THIS IS THE DASHBOARD PAGE</h1>
        <form action="submit_evaluation.php" method="POST">
    <input type="hidden" name="student_id" value="123"> <!-- dynamic -->

<table class="table table-bordered">
        <thead>
            <tr>
                <th>Evaluator Role</th>
                <th>Chapter</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <!-- Adviser Comments -->
            <tr>
                <td>Adviser</td>
                <td>Chapter 1</td>
                <td><textarea name="comments[Adviser][Chapter 1]" rows="2" class="form-control"></textarea></td>
            </tr>
            <tr>
                <td>Adviser</td>
                <td>Chapter 2</td>
                <td><textarea name="comments[Adviser][Chapter 2]" rows="2" class="form-control"></textarea></td>
            </tr>

            <!-- Panelist Comments -->
            <tr>
                <td>Panelist</td>
                <td>Chapter 1</td>
                <td><textarea name="comments[Panelist][Chapter 1]" rows="2" class="form-control"></textarea></td>
            </tr>
            <tr>
                <td>Panelist</td>
                <td>Chapter 2</td>
                <td><textarea name="comments[Panelist][Chapter 2]" rows="2" class="form-control"></textarea></td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Submit Evaluation</button>
</form>

    </div>

</div>
</body>
</html>