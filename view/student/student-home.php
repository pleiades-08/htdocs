<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>STUDENT | Profile</title>
</head>
<body>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/sidebar.php'; ?>
    <br>
    <main class="flex-grow-1 p-4">
        <div class="content-page">
            <h1 style="margin: 100px 50px 50px 50px;">THIS IS THE HOME PAGE</h1>
            <p>Student Name: <strong><?php echo htmlspecialchars($fetch['first_name'] . " " . $fetch['last_name']); ?></strong></p>
            <p>ROLE: <strong><?php echo htmlspecialchars($fetch['user_type']); ?></strong></p>
            <p>Department: <strong><?php echo htmlspecialchars($fetch['dept']); ?></strong></p>
        </div>
    </main> 
    
</div>
</body>
</html>