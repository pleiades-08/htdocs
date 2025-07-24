<?php
// Database connection
include 'FetchUserStatus.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
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
    </style>
</head>
<body>

<ul>
    <li><a href="#home">Home</a></li>
    <li><a class="active" href="Manage_Account.php">Manage Accounts</a></li>
    <li><a href="#GnrtRep">Generate Report</a></li>
    <li><a href="#Imp/ExpDtb">Import/Export Database</a></li>
    <li><a href="#Dashb">Dashboard</a></li>
</ul>

<div style="margin-left:25%;padding:1px 16px;height:1000px;">
    <h1>Manage Accounts</h1><br>

    <button onclick="openModal()">Add Account</button>

    <h3>Active Accounts List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Account Name</th>
                <th>Account Type</th>
                <th>Section/Department</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($active_accounts as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td><?= htmlspecialchars($row['dept']) ?></td>
                    <td><?= htmlspecialchars($row['status_']) ?></td>
                    <td>
                        <button type="button" onclick="openViewModal(<?= $row['user_id'] ?>)">View</button>
                        <button type="button" onclick="openEditModal(<?= $row['user_id'] ?>)">Edit</button>
                        <form action="MngAccArchiveUser.php" method="GET" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']) ?>">
                            <button type="submit">Archive</button>
                        </form>
                        <form action="../Actions/Deactivate_User.php" method="GET" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']) ?>">
                            <button type="submit">Deactivate</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Inactive Accounts List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Account Name</th>
                <th>Account Type</th>
                <th>Section/Department</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inactive_accounts as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td><?= htmlspecialchars($row['dept']) ?></td>
                    <td><?= htmlspecialchars($row['status_']) ?></td>
                    <td>
                        <button type="button" onclick="openViewModal(<?= $row['user_id'] ?>)">View</button>
                        <form action="MngAccArchiveUser.php" method="GET" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']) ?>">
                            <button type="submit">Archive</button>
                        </form>
                        <form action="../Actions/Activate_User.php" method="GET" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']) ?>">
                            <button type="submit">Activate</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal Add User Form -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Add User Form</h3>

            <form action="../Actions/Add_User.php" method="post" id="Register">
                <label>Account Type</label>
                <select id="role" name="role" onchange="switchForm()" required>
                    <option value="" disabled selected>-- Select Account Type --</option>
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Librarian">Librarian</option>
                </select>

                <div id="form-Student" class="form-section">
                    <label>ID Number:</label>
                    <input type="text" name="school_id" placeholder="Enter ID Number">
                    <label>KLD Email:</label>
                    <input type="email" name="kldemail" placeholder="Enter KLD Email">
                    <label>Username:</label>
                    <input type="text" name="username" placeholder="Enter Username">
                    <label>Password:</label>
                    <input type="password" name="password" placeholder="Enter Password"><br>
                    <label>First Name:</label>
                    <input type="text" name="fname" placeholder="Enter First Name">
                    <label>Middle Name:</label>
                    <input type="text" name="mname" placeholder="Enter Middle Name">
                    <label>Last Name:</label>
                    <input type="text" name="lname" placeholder="Enter Last Name">
                    <label>Course/Year/Section:</label>
                    <input type="text" name="dept" placeholder="Enter Course/Year/Section">
                </div>

                <div id="form-Faculty" class="form-section">
                    <label>ID Number:</label>
                    <input type="text" name="school_id" placeholder="Enter ID Number">
                    <label>KLD Email:</label>
                    <input type="email" name="kldemail" placeholder="Enter KLD Email">
                    <label>Username:</label>
                    <input type="text" name="username" placeholder="Enter Username">
                    <label>Password:</label>
                    <input type="password" name="password" placeholder="Enter Password"><br>
                    <label>First Name:</label>
                    <input type="text" name="fname" placeholder="Enter First Name">
                    <label>Middle Name:</label>
                    <input type="text" name="mname" placeholder="Enter Middle Name">
                    <label>Last Name:</label>
                    <input type="text" name="lname" placeholder="Enter Last Name">
                    <label>Institute/Department:</label>
                    <input type="text" name="dept" placeholder="Enter Institute/Department">
                </div>

                <div id="form-Librarian" class="form-section">
                    <label>ID Number:</label>
                    <input type="text" name="school_id" placeholder="Enter ID Number">
                    <label>KLD Email:</label>
                    <input type="email" name="kldemail" placeholder="Enter KLD Email">
                    <label>Username:</label>
                    <input type="text" name="username" placeholder="Enter Username">
                    <label>Password:</label>
                    <input type="password" name="password" placeholder="Enter Password"><br>
                    <label>First Name:</label>
                    <input type="text" name="fname" placeholder="Enter First Name">
                    <label>Middle Name:</label>
                    <input type="text" name="mname" placeholder="Enter Middle Name">
                    <label>Last Name:</label>
                    <input type="text" name="lname" placeholder="Enter Last Name">
                    <label>Institute/Department:</label>
                    <input type="text" name="dept" placeholder="Enter Institute/Department">
                </div>

                <button type="submit" name="submit">Submit</button>
                <button type="button" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal" style="display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color:#fff; margin:10% auto; padding:20px; border:1px solid #888; width:40%;">
            <span class="close" onclick="closeEditModal()" style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer;">&times;</span>
            <h2>Edit Account Information</h2>
            <form action="../Actions/Edit_User.php" method="POST" id="editForm">
                <input type="hidden" name="user_id" value="">

                <label>School ID:</label><br>
                <input type="text" name="school_id" value="" required>

                <label>KLD Email:</label><br>
                <input type="email" name="kldemail" value="" required>

                <label>Username:</label><br>
                <input type="text" name="username" value="" required>

                <label>New Password (leave blank to keep current):</label><br>
                <input type="password" name="password">

                <label>First Name:</label><br>
                <input type="text" name="fname" value="" required>

                <label>Middle Name:</label><br>
                <input type="text" name="mname" value="">

                <label>Last Name:</label><br>
                <input type="text" name="lname" value="" required>

                <label id="editdeptLabel">Department:</label><br>
                <input type="text" name="dept" value="" required>

                <button type="submit" name="submit">Update</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>


    <div id="viewModal" class="modal" style="display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color:#fff; margin:10% auto; padding:20px; border:1px solid #888; width:40%;">
            <span class="close" onclick="closeViewModal()" style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer;">&times;</span>
            <h2>View Account Information</h2>
            <form id="viewForm">
                <input type="hidden" name="user_id" value="">

                <label>School ID:</label><br>
                <input type="text" name="school_id" value="" readonly>

                <label>KLD Email:</label><br>
                <input type="email" name="kldemail" value="" readonly>

                <label>Username:</label><br>
                <input type="text" name="username" value="" readonly>

                <label>First Name:</label><br>
                <input type="text" name="fname" value="" readonly>

                <label>Middle Name:</label><br>
                <input type="text" name="mname" value="" readonly>

                <label>Last Name:</label><br>
                <input type="text" name="lname" value="" readonly>

                <label id="viewdeptLabel">Department:</label><br>
                <input type="text" name="dept" value="" readonly>

                <button type="button" onclick="closeViewModal()">Back</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('userModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('userModal').style.display = 'none';
        resetForm();
    }

    function switchForm() {
        const selected = document.getElementById('role').value;
        const sections = document.querySelectorAll('.form-section');
        sections.forEach(section => {
            if (section.id === `form-${selected}`) {
                section.classList.add('active');
                section.querySelectorAll('input, select').forEach(input => input.disabled = false);
            } else {
                section.classList.remove('active');
                section.querySelectorAll('input, select').forEach(input => input.disabled = true);
            }
        });
    }

    function resetForm() {
        document.getElementById('Register').reset();
        document.querySelectorAll('.form-section').forEach(section => {
            section.classList.remove('active');
            section.querySelectorAll('input, select').forEach(input => input.disabled = true);
        });
    }

    window.onload = resetForm;

    window.onclick = function(event) {
        if (event.target === document.getElementById('userModal')) {
            closeModal();
        }
    };

    function openEditModal(userId) {
    fetch(`FetchUserDetails.php?user_id=${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch user details.');
            }
            return response.json();
        })
        .then(data => {
            const editModal = document.getElementById('editModal');
            editModal.querySelector('[name="user_id"]').value = data.user_id;
            editModal.querySelector('[name="school_id"]').value = data.school_id;
            editModal.querySelector('[name="kldemail"]').value = data.kldemail;
            editModal.querySelector('[name="username"]').value = data.username;
            editModal.querySelector('[name="fname"]').value = data.fname;
            editModal.querySelector('[name="mname"]').value = data.mname;
            editModal.querySelector('[name="lname"]').value = data.lname;
            editModal.querySelector('[name="dept"]').value = data.dept;

            updateEditDeptLabel(data.role);

            editModal.style.display = 'block';
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.getElementById('editForm').reset();
    }

    function openViewModal(userId) {
    fetch(`FetchUserDetails.php?user_id=${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch user details.');
            }
            return response.json();
        })
        .then(data => {
            const viewModal = document.getElementById('viewModal');
            viewModal.querySelector('[name="user_id"]').value = data.user_id;
            viewModal.querySelector('[name="school_id"]').value = data.school_id;
            viewModal.querySelector('[name="kldemail"]').value = data.kldemail;
            viewModal.querySelector('[name="username"]').value = data.username;
            viewModal.querySelector('[name="fname"]').value = data.fname;
            viewModal.querySelector('[name="mname"]').value = data.mname;
            viewModal.querySelector('[name="lname"]').value = data.lname;
            viewModal.querySelector('[name="dept"]').value = data.dept;

            updateViewDeptLabel(data.role);

            viewModal.style.display = 'block';
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }

    function closeViewModal() {
        document.getElementById('viewModal').style.display = 'none';
        document.getElementById('viewForm').reset();
    }

    function updateEditDeptLabel(role) {
    const label = document.getElementById('editdeptLabel');
    if (role === 'Student') {
        label.textContent = 'Section:';
    } else {
        label.textContent = 'Department:';
    }
    }

    function updateViewDeptLabel(role) {
    const label = document.getElementById('viewdeptLabel');
    if (role === 'Student') {
        label.textContent = 'Section:';
    } else {
        label.textContent = 'Department:';
    }
    }
</script>

</body>
</html>
