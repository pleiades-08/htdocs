<?php



$userType = $fetch['user_type'] ?? null;

$_SESSION['user_role'] = $userType;

// Set role flags
$_SESSION['is_admin'] = ($userType === 'admin');
$_SESSION['is_coordinator'] = ($userType === 'coordinator');
$_SESSION['is_faculty'] = in_array($userType, ['faculty', 'admin', 'coordinator']);
$_SESSION['is_student'] = ($userType === 'student');

require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchStudentTeam.php';
?>

<div class="sidebar">

<div class="logo-container">
    <img src="/assets/img/kld-logo.png" alt="KLD" class="kld-logo">
    <strong style="color: #fff; font-size: 20px;"><?php echo htmlspecialchars($userType); ?></strong>
</div>

<?php if ($_SESSION['user_role']) : ?>
    
    <?php if ($_SESSION['is_faculty']) : ?>

            <a href="/imacs-home">Home</a>
            <a href="/imacs-dashboard">Dashboard</a>
            <a href="/imacs-documents">Documents</a>
                <div class="dropdown">
                <button class="dropbtn">Workspace <span style="margin-left: 10px;" class="arrow"><strong>></strong> </span></button>
                <div class="dropdown-content">
                    <a style="margin:10px 0 0 10px;" href="/imacs-capstone_teams">Capstone Team</a>
                    <a style="margin:10px 0 0 10px;" href="/imacs-capstone_titles">Capstone Titles</a>
                    <a style="margin:10px 0 0 10px;" href="/imacs-add_teams">Add Teams</a>
                </div>
            </div>
            <a href="/imacs-profile">Profile</a>

        <?php if ($_SESSION['is_admin']): ?>

            <a href="/admin-manage">Manage Account</a>
            
        <?php endif; ?>

        <?php if ($_SESSION['is_coordinator']): ?>

            <a href="/research-coor-manage_roles">Manage Roles</a>

        <?php endif; ?>

    <?php endif; ?>

    <?php if ($_SESSION['is_student']) : ?>

        <a href="/student-home">Home</a>
        <a href="/student-dashboard">Dashboard</a>

        <?php if ($isInTeam): ?>
            <!-- Show something for users in a team -->
            <div class="dropdown">
                <button class="dropbtn">Teams <span style="margin-left: 10px;" class="arrow"><strong>></strong> </span></button>
                <div class="dropdown-content">
                    <a style="margin:10px 0 0 10px;" href="/student-capstone_teams">Capstone Team</a>
                    <a style="margin:10px 0 0 10px;" href="/student-upload">Upload</a>
                    <a style="margin:10px 0 0 10px;" href="/student-request_schedule">Schdule</a>
                </div>
            </div>
        <?php else: ?>
            <a href="/student-no_team">Teams</a>
        <?php endif; ?>

        <a href="/student-profile">Profile</a>
    
    <?php endif; ?>

        <a href="/logout">Logout</a>

<?php endif; ?>

</div>