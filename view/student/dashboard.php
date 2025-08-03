<?php
require $_SERVER['DOCUMENT_ROOT']  . './actions/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserType.php';
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
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>
    <br>
    <main>
        <div class="content-page">
            <h1 class="text-center my-5">Dashboard</h1>
            <p class="text-center">Welcome to the IMACS Dashboard!</p>
            <p class="text-center">Here you can manage your documents, teams, and more.</p>
        </div>
    </main>

</body>
</html>