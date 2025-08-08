<?php
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserType.php';

$userType = $side['user_type'] ?? null;
$_SESSION['user_role'] = $userType;

// Set role flags
$_SESSION['is_admin'] = ($userType === 'admin');
$_SESSION['is_coordinator'] = ($userType === 'coordinator');
$_SESSION['is_faculty'] = in_array($userType, ['faculty', 'admin', 'coordinator']);
$_SESSION['is_student'] = ($userType === 'student');

require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchStudentTeam.php';

?>

<div id="sidebar" class="sidebar-collapsed d-flex flex-column shadow">
    <button onclick="toggleSidebar()" class="btn bg-transparent border-0 toggle-btn">
        <!-- Hamburger Icon -->
        <svg class="bi bi-list" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm0-4a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm0-4a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11z"/>
        </svg>
    </button>

    <nav class="d-flex flex-column mt-3 gap-2 px-2">
        <?php if ($_SESSION['user_role']) : ?>
            
            <?php if ($_SESSION['is_faculty']) : ?>
                <!-- Icon always visible -->
                <button onclick="window.location.href='/imacs-home'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Home</span>
                </button>

                <button onclick="window.location.href='/imacs-dashboard'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 8 1.35 8 4v2H4v-2c0-2.65 5.3-4 8-4zm0-2a4 4 0 1 0-4-4 4 4 0 0 0 4 4z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Dashboard</span>
                </button>

                <button onclick="window.location.href='/imacs-capstone_teams'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2 6h20v2H2V6zm0 5h20v2H2v-2zm0 5h20v2H2v-2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Capstone Team</span>
                </button>

                <button onclick="window.location.href='/imacs-capstone_titles'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Capstone Titles</span>
                </button>

                <button onclick="window.location.href='/imacs-documents'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Documents</span>
                </button>

                <button onclick="window.location.href='/imacs-add_teams'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Add Teams</span>
                </button>

                <button onclick="window.location.href='/imacs-profile'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Profile</span>
                </button>

                <?php if ($_SESSION['is_admin']): ?>
                    <button onclick="window.location.href='/admin-manage'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                        <span class="icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                            </svg>
                        </span>
                        <span class="label label-hidden">Manage Account</span>
                    </button>
                <?php endif; ?>

                <?php if ($_SESSION['is_coordinator']): ?>
                    <button onclick="window.location.href='/research-coor-manage_roles'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                        <span class="icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                            </svg>
                        </span>
                        <span class="label label-hidden">Manage Roles</span>
                    </button>

                    <button onclick="window.location.href='/research-coor-set_schedules'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                        <span class="icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                            </svg>
                        </span>
                        <span class="label label-hidden">Set Schedules</span>
                    </button>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ($_SESSION['is_student']) : ?>
                <button onclick="window.location.href='/student-home'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Home</span>
                </button>

                <button onclick="window.location.href='/student-dashboard'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Dashboard</span>
                </button>

                <?php if ($isInTeam): ?>
                    <button onclick="window.location.href='/student-capstone_teams'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                        <span class="icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                            </svg>
                        </span>
                        <span class="label label-hidden">Capstone Team</span>
                    </button>

                    <button onclick="window.location.href='/student-upload'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                        <span class="icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                            </svg>
                        </span>
                        <span class="label label-hidden">Upload</span>
                    </button>

                    <button onclick="window.location.href='/student-request_schedule'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                        <span class="icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                            </svg>
                        </span>
                        <span class="label label-hidden">Schedule</span>
                    </button>
                <?php else: ?>
                    <button onclick="window.location.href='/student-no_team'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                        <span class="icon">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                            </svg>
                        </span>
                        <span class="label label-hidden">Teams</span>
                    </button>
                <?php endif; ?>
                
                <button onclick="window.location.href='/student-profile'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                    <span class="icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                        </svg>
                    </span>
                    <span class="label label-hidden">Profile</span>
                </button>    
            <?php endif; ?>

            <button onclick="window.location.href='/logout'" class="btn d-flex align-items-center gap-3 text-white fw-bold">
                <span class="icon">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z" />
                    </svg>
                </span>
                <span class="label label-hidden">Logout</span>
            </button>

        <?php endif; ?>
    </nav>                  
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUser.php'; ?>
<!-- Bootstrap JS (for any potential future use) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar Toggle Script -->
<script>
    const sidebar = document.getElementById("sidebar");

    function toggleSidebar() {
        sidebar.classList.toggle("sidebar-expanded");
        sidebar.classList.toggle("sidebar-collapsed");

        document.querySelectorAll(".label").forEach(label => {
            label.classList.toggle("label-visible");
            label.classList.toggle("label-hidden");
        });
    }

    // Load sidebar state on page load
</script>
