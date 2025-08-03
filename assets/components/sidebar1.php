<?php


$userType = $fetch['user_type'] ?? null;

$_SESSION['user_role'] = $userType;

// Set role flags
$_SESSION['is_admin'] = ($userType === 'admin');
$_SESSION['is_coordinator'] = ($userType === 'research_coordinator');
$_SESSION['is_faculty'] = in_array($userType, ['faculty', 'admin', 'research_coordinator']);
$_SESSION['is_student'] = ($userType === 'student');

?>
<!-- Sidebar -->
<div
    id="sidebar"
    class="sidebar-collapsed sidebar-transition bg-white shadow-md h-screen z-[999] flex flex-col">
    <!-- Toggle Button -->
    <button
        onclick="toggleSidebar()"
        class="p-4 focus:outline-none hover:bg-gray-100 transition"
        aria-label="Toggle Sidebar">
        <!-- Hamburger Icon -->
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    
    <!-- Navigation Buttons -->
    <nav class="flex flex-col mt-4 space-y-2">
    
        <!--for student user type-->
        <?php if ($_SESSION['is_student']) : ?>
            <button onclick="window.location.href='/student-dashboard'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z" />
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Dashboard</span>
            </button>

            <button onclick="window.location.href='/student-documents'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 8 1.35 8 4v2H4v-2c0-2.65 5.3-4 8-4zm0-2a4 4 0 1 0-4-4 4 4 0 0 0 4 4z" />
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Documents</span>
            </button>

            <button onclick="window.location.href='/student-capstone_teams'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2 6h20v2H2V6zm0 5h20v2H2v-2zm0 5h20v2H2v-2z" />
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Capstone Team</span>
            </button>

            <button onclick="window.location.href='/student-upload'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z"/>
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Upload</span>
            </button>

            <button onclick="window.location.href='/student-request_schedule'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z"/>
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Request Schedule</span>
            </button>

            <button onclick="window.location.href='/logout'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z"/>
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Logout</span>
            </button>
        <?php endif; ?>

            <!--for faculty user type-->
        <?php if ($_SESSION['is_faculty']) : ?>

            <?php if ($_SESSION['is_admin']): ?>

                <button onclick="window.location.href='/admin-manage'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                    <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z" />
                    </svg>
                    <span class="label label-hidden transition-opacity duration-300">Manage Account</span>
                </button>

            <?php endif; ?>
        
            <?php if ($_SESSION['is_coordinator']): ?>

                <button onclick="window.location.href='/research-coor-manage_roles'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                    <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z" />
                    </svg>
                    <span class="label label-hidden transition-opacity duration-300">Manage Roles</span>
                </button>

            <?php endif; ?>


            <button onclick="window.location.href='/imacs-dashboard'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z" />
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Dashboard</span>
            </button>

            <button onclick="window.location.href='/imacs-documents'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 8 1.35 8 4v2H4v-2c0-2.65 5.3-4 8-4zm0-2a4 4 0 1 0-4-4 4 4 0 0 0 4 4z" />
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Documents</span>
            </button>

            <button onclick="window.location.href='/imacs-upload'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2 6h20v2H2V6zm0 5h20v2H2v-2zm0 5h20v2H2v-2z" />
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Upload</span>
            </button>

            <button onclick="window.location.href='/imacs-capstone_teams'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z"/>
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Capstone Teams</span>
            </button>

            <button onclick="window.location.href='/imacs-capstone_titles'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z"/>
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Capstone Title</span>
            </button>

            <button onclick="window.location.href='/imacs-add_teams'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z"/>
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Add Teams</span>
            </button>

            <button onclick="window.location.href='/logout'" class="flex items-center gap-3 p-3 hover:bg-gray-100 transition text-white font-bold font-poppins">
                <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22c5.52 0 10-4.48 10-10S17.52 2 12 2 2 6.48 2 12s4.48 10 10 10zm1-17v6h-2V5h2zm0 8v2h-2v-2h2z"/>
                </svg>
                <span class="label label-hidden transition-opacity duration-300">Logout</span>
            </button>
        <?php endif; ?>
    </nav>
</div>


<aside>
    <nav>
        <ul>
            <li>
                <a href=" " class="active">
                    <h4>logo here</h4>
                    <span>Dashboard </span>
                </a>
            </li>
            <li>
                <a href=" ">
                    <h4>logo here</h4>
                    <span>Dashboard </span>
                </a>
            </li>
            <li>
                <a href=" ">
                    <h4>logo here</h4>
                    <span>Dashboard </span>
                </a>
            </li>
            <li>
                <a href=" ">
                    <h4>logo here</h4>
                    <span>Dashboard </span>
                </a>
            </li>
            <li>
                <a href=" ">
                    <h4>logo here</h4>
                    <span>Dashboard </span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<main>
    <div class="content">
        <!-- Main content goes here -->
        <h1>Welcome to the Dashboard</h1>
        <p>This is the main content area.</p>
    </div>
</main>

<script>
    const resizeBtn = document.querySelector('[data-resize-btn]');
    resizeBtn.addEventListener('click', function(e){
        e.preventDefault();
        document.body.classList.toggle('sb-expanded');
    });
</script>