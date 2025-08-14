<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>IMACS FACULTY | Profile</title>
</head>
<body>    
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>
    <br>

    
    <main class="flex-grow-1 p-4">
        <div class="content-page">
            <h1 style="margin: 100px 50px 50px 50px;">THIS IS THE PROFILE PAGE</h1>
            <form action="submit_evaluation.php" method="POST">
            <input type="hidden" name="student_id" value="123"> <!-- dynamic -->
        </div>
    </main>
    <script src="/js/components.js"></script>

</body>
</html>