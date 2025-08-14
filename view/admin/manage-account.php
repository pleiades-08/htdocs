<?php
// Database connection
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/component.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Manage Accounts</title>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow:scroll;
    }
    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 20px;
        width: 50%;
        border-radius: 8px;
        position: relative;
    }
    .close {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
    }
    .form-section {
        display: none;
    }
    .form-section.active {
        display: block;
    }
    th[data-column] {
        cursor: pointer;
        user-select: none;
    }
</style>


</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>
    <br>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check-circle-fill" viewBox="0 0 16 16">
        <path d="..."/> <!-- Keep your existing path -->
    </symbol>
    <symbol id="info-fill" viewBox="0 0 16 16">
        <path d="..."/>
    </symbol>
    <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
        <path d="..."/>
    </symbol>
    </svg>

    <main class="flex-grow-1 p-4">
        <div class="content-page">
            <div class="add-acc" style="padding: 30px">
                <div class="manage-acc">
                    <h1>Manage Accounts</h1><br>
                    <button onclick="openModal()" class="btn btn-primary">Add Account</button>
                </div>
                <div class="info">
                    <h1>ADD SOMETHING HERE...</h1>
                </div>
            </div>
            <div class="search">
                <form method="GET" action="../../router/router.php">
                    <input type="hidden" name="page" value="imacs-documents">
                    <input type="text" name="search" class="search-bar" placeholder="Search by title, type..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <h3 style="padding: 30px">Active Accounts List</h3>
            <table class="table table-striped table-hover mb-4 data_table" style="width: 100%;" id="activeTable">
                <div id="alertContainer" class="mt-3"></div>
                <thead>
                <tr>
                    <th style="width: 20px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAllActive" class="form-check-input">
                    </div>
                    </th>
                    <th data-column="school_id" data-order="desc" data-label="ID" style="width: auto;">ID ▼</th>
                    <th data-column="fullname" data-order="desc" data-label="Name" style="width: auto;">Name ▼</th>
                    <th data-column="user_type" data-order="desc" data-label="Type" style="width: auto;">Type ▼</th>
                    <th data-column="dept" data-order="desc" data-label="Department" style="width: auto;">Department ▼</th>
                    <th data-column="status_" data-order="desc" data-label="Status" style="width: auto;">Status ▼</th>
                    <th style="width: auto;">Action</th>
                </tr>
                </thead>

                <tbody id="activeTable">
                    <!-- Active accounts will be populated here by JavaScript -->
                </tbody>
            </table>

            <h3 style="padding: 30px">Inactive Accounts List</h3>
            <table class="table table-striped table-hover mb-4 data_table" style="width: 100%;" id="inactiveTable">
                <thead>
                    <tr>
                        <th style="width: 20px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkAllInactive">
                            </div>
                        </th>
                        <th data-column="school_id" data-order="desc" data-label="ID" style="width: 80px;">ID ▼</th>
                        <th data-column="fullname" data-order="desc" data-label="Name" style="width: 300px;">Name ▼</th>
                        <th data-column="user_type" data-order="desc" data-label="Type" style="width: 50px;">Type ▼</th>
                        <th data-column="dept" data-order="desc" data-label="Department" style="width: 50px;">Department ▼</th>
                        <th data-column="status_" data-order="desc" data-label="Status" style="width: 100px;">Status ▼</th>
                        <th style="width: 200px;">Action</th>
                    </tr>
                </thead>
                <tbody id="inactiveTable">
                    <!-- Inactive accounts will be populated here by JavaScript -->
                </tbody>
            </table>

            <!-- Modal Add User Form -->
            <div id="userModal" class="modal">
                <div class="modal-content p-4">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3>Add User Form</h3>
                    <!-- Form to add a new user -->
                    
                    <form action="/actions/add_user.php" method="post" id="Register">
                        <div class="mb-3">
                            <label class="form-label">Account Type</label>
                            <select id="user_type" name="user_type" onchange="switchForm()" class="form-select" required>
                                <option value="" disabled selected>-- Select Account Type --</option>
                                <option value="Student">Student</option>
                                <option value="Faculty">Faculty</option>
                                <option value="Librarian">Librarian</option>
                            </select>
                        </div>
                        <!-- Form sections for different user types -->
                        
                        <!-- Student Form -->
                        <div id="form-Student" class="form-section">
                            <div class="mb-3">
                                <label class="form-label">ID Number:</label>
                                <input type="text" name="school_id" class="form-control" placeholder="Enter ID Number">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">KLD Email:</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter KLD Email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username:</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Username">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter First Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Middle Name:</label>
                                <input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Course/Year/Section:</label>
                                <input type="text" name="dept" class="form-control" placeholder="Enter Course/Year/Section">
                            </div>
                        </div>

                        <div id="form-Faculty" class="form-section">
                            <div class="mb-3">
                                <label class="form-label">ID Number:</label>
                                <input type="text" name="school_id" class="form-control" placeholder="Enter ID Number">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">KLD Email:</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter KLD Email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username:</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Username">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter First Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Middle Name:</label>
                                <input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Course/Year/Section:</label>
                                <input type="text" name="dept" class="form-control" placeholder="Enter Institute/Department">
                            </div>
                        </div>

                        <!-- LIBRARIAN Form -->
                        <div id="form-Librarian" class="form-section">
                            <div class="mb-3">
                                <label class="form-label">ID Number:</label>
                                <input type="text" name="school_id" class="form-control" placeholder="Enter ID Number">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">KLD Email:</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter KLD Email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username:</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Username">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter First Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Middle Name:</label>
                                <input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Institute/Department:</label>
                                <input type="text" name="dept" class="form-control" placeholder="Enter Institute/Department">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                            <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit and View Modals -->
            <div id="editModal" class="modal">
                <div class="modal-content p-4">
                    <span class="close" onclick="closeEditModal()">&times;</span>
                    <h2>Edit Account Information</h2>
                    <form action="/actions/edit_user.php" method="POST" id="editForm">
                        <input type="hidden" name="user_id" value="">

                        <div class="mb-3">
                            <label class="form-label">School ID:</label>
                            <input type="text" class="form-control" name="school_id" value="" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KLD Email:</label>
                            <input type="email" class="form-control"name="email" value="" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" class="form-control"name="username" value="" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password (leave blank to keep current):</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name:</label>
                            <input type="text" class="form-control" name="first_name" value="" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Middle Name:</label>
                            <input type="text" class="form-control" name="middle_name" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name:</label>
                            <input type="text" class="form-control" name="last_name" value="" required>
                        </div>
                        <div class="mb-3">
                            <label id="editdeptLabel" class="form-label">Department:</label>
                            <input type="text" class="form-control" name="dept" value="" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Cancel</button>
                    </form>
                </div>
            </div>


            <div id="viewModal" class="modal">
                <div class="modal-content p-4">
                    <span class="close" onclick="closeViewModal()">&times;</span>
                    <h2>View Account Information</h2>
                    <form id="viewForm">
                        <input type="hidden" name="user_id" value="">
                        <br>

                        <div class="mb-3">
                            <label class="form-label">School ID:</label>
                            <input type="text" class="form-control" name="school_id" value="" readonly>
                        </div>  

                        <div class="mb-3">
                            <label class="form-label">KLD Email:</label>
                            <input type="text" class="form-control" name="email" value="" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" class="form-control" name="username" value="" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">First Name:</label>
                            <input type="text" class="form-control" name="first_name" value="" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Middle Name:</label>
                            <input type="text" class="form-control" name="middle_name" value="" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name:</label>
                            <input type="text" class="form-control" name="last_name" value="" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label id="viewdeptLabel" class="form-label">Department:</label>
                            <input type="text" class="form-control" name="dept" value="" readonly>
                        </div>
                        <button type="button" onclick="closeViewModal()" class="btn btn-secondary">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
<script>

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="/js/manage_acc.js"></script>
<script src="/js/helper.js"></script>
<script src="/js/fetch_user.js"></script>
<script src="/js/checkbox.js"></script>

</body>
</html>
