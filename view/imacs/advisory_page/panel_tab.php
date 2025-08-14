<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUser.php';
require $_SERVER['DOCUMENT_ROOT'] . './actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchDefenseDates.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>Panel Tab</title>
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . './assets/components/sidebar.php'; ?>
<br>

<main class="flex-grow-1 p-4">
    <div class="content-page">
        <div class="container mt-4">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">📋 Panelist Evaluation Dashboard</h4>
                <span class="text-muted">Welcome, Panelist</span>
            </div>

            <!-- Teams Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    Assigned Teams
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Team Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Defense Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Row -->
                                <tr>
                                    <td>1</td>
                                    <td>Team Alpha</td>
                                    <td>Prof. Santos</td>
                                    <td>2025-08-15</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Pending Evaluation</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="evaluate.php?team_id=1" class="btn btn-sm btn-success">
                                            Evaluate
                                        </a>
                                        <a href="view-team.php?team_id=1" class="btn btn-sm btn-secondary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>Team Beta</td>
                                    <td>Prof. Cruz</td>
                                    <td>2025-08-20</td>
                                    <td>
                                        <span class="badge bg-success">Evaluated</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="view-results.php?team_id=2" class="btn btn-sm btn-info text-white">
                                            View Results
                                        </a>
                                    </td>
                                </tr>

                                <!-- More rows populated via PHP -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

</body>
</html>