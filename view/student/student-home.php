<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserType.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/component.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Sidebar Test</title>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>

    <!-- PUT YOUR SIDE CONTEMT HERE-->
    <main class="">
        <div class="content-page">
            <div class="col-md-3"></div>
            <h1 style="margin: 100px 50px 50px 50px;">THIS IS THE HOME PAGE</h1>
            <p>Student Name: <strong><?php echo htmlspecialchars($fetch['first_name'] . " " . $fetch['last_name']); ?></strong></p>
            <p>ROLE: <strong><?php echo htmlspecialchars($fetch['user_type']); ?></strong></p>
            <p>Department: <strong><?php echo htmlspecialchars($fetch['dept']); ?></strong></p>
        </div>
    </main>
    
    <!-- Main content -->
    
    <!-- JS Toggle Logic -->


</body>
</html>
