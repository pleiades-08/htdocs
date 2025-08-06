<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserType.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchTeamdisplay.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchPanelRole.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
</head>
<body>
    <style>
        /* Modal Styles */
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
            height: 90%;
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

<main>
    <div class="content-page">
        <h1>Workspace</h1><br>
        <h3>Capstone Teams</h3>

        <div class="table-responsive">
            <table class="table align-middle table-striped table-hover mb-4 data_table" style="width: 100%;" id="activeTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Authors</th>
                        <th>Research</th>
                        <th>Adviser</th>
                        <th>Technical</th>
                        <th>Chairperson</th>
                        <th>Major</th>
                        <th>Minor</th>
                        <th>Panelist</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php if (!empty($user_is_on_team)): ?>
                        <?php foreach ($user_is_on_team as $team): ?>
                            <tr>
                                <td><?= htmlspecialchars($team['capstone_title']) ?></td>
                                <td>
                                    <?php 
                                        $members = explode(', ', $team['members']);
                                        foreach ($members as $member) {
                                            if (strpos($member, '(Leader)') !== false) {
                                                echo htmlspecialchars($member) . '<br>';
                                            } else {
                                                echo htmlspecialchars($member) . '<br>';
                                            }
                                        }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($team['capstone_type']) ?></td>
                                <td><?= htmlspecialchars($team['adviser_name']) ?></td>
                                <td><?= htmlspecialchars($team['technical_name']) ?></td>
                                <td><?= htmlspecialchars($team['chairman_name']) ?><br></td>
                                <td><?= htmlspecialchars($team['major_name']) ?><br></td>
                                <td><?= htmlspecialchars($team['minor_name']) ?><br></td>
                                <td><?= htmlspecialchars($team['panelist_name']) ?><br></td>
                                <td>
                                    <button 
                                        type="button" 
                                        class="btn btn-primary openModalBtn"
                                        data-team-id="<?= htmlspecialchars($team['team_id']) ?>"
                                        data-title="<?= htmlspecialchars($team['capstone_title']) ?>"
                                        data-chairperson="<?= htmlspecialchars($team['chairman_name']) ?>"
                                        data-technical="<?= htmlspecialchars($team['technical_name']) ?>"
                                        data-major="<?= htmlspecialchars($team['major_name']) ?>"
                                        data-minor="<?= htmlspecialchars($team['minor_name']) ?>"
                                        data-panel="<?= htmlspecialchars($team['panelist_name']) ?>">
                                        Assign
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No teams available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>  
        <!-- Modal -->
        <div id="assignModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModalBtn">&times;</span>
                <h3 id="modalTitle">Assign Panel Members</h3>

                <form action="/actions/assign_roles.php" method="POST">
                    <input type="hidden" name="team_id" id="modalTeamId">

                    <!-- Technical -->
                    <div class="mb-3">
                        <label for="modalTechnical" class="form-label">Chair Person:</label>
                        <select name="technical_name" id="modalTechnical" class="form-select">
                            <option value="">Select Chair Person</option>
                            <?php foreach ($faculty as $id => $name): ?>
                                <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modalChairperson" class="form-label">Chair Person:</label>
                        <select name="chairman_name" id="modalChairperson" class="form-select">
                            <option value="">Select Chair Person</option>
                            <?php foreach ($faculty as $id => $name): ?>
                                <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Major Discipline -->
                    <div class="mb-3">
                        <label for="modalMajor" class="form-label">Major Discipline:</label>
                        <select name="major_name" id="modalMajor" class="form-select">
                            <option value="">Select Major Discipline</option>
                            <?php foreach ($faculty as $id => $name): ?>
                                <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Minor Discipline -->
                    <div class="mb-3">
                        <label for="modalMinor" class="form-label">Minor Discipline:</label>
                        <select name="minor_name" id="modalMinor" class="form-select">
                            <option value="">Select Minor Discipline</option>
                            <?php foreach ($faculty as $id => $name): ?>
                                <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Panelist -->
                    <div class="mb-3">
                        <label for="modalPanel" class="form-label">Select Panelist:</label>
                        <select name="panelist_name" id="modalPanel" class="form-select">
                            <option value="">Select Panelist</option>
                            <?php foreach ($faculty as $id => $name): ?>
                                <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="justify-content-between">
                        <button type="submit" class="btn btn-primary">Assign Panel</button>
                        <button type="button" id="cancelModalBtn" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>
<script>
    const modal = document.getElementById('assignModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const openButtons = document.querySelectorAll('.openModalBtn');

    const teamIdInput = document.getElementById('modalTeamId');
    const techSelect = document.getElementById('modalTechnical');
    const chairSelect = document.getElementById('modalChairperson');
    const majorSelect = document.getElementById('modalMajor');
    const minorSelect = document.getElementById('modalMinor');
    const panelSelect = document.getElementById('modalPanel');
    const modalTitle = document.getElementById('modalTitle');

    // Open Modal & Populate Data
    openButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const teamId = btn.dataset.teamId;
            const title = btn.dataset.title;
            const techName = btn.dataset.technical;
            const chairName = btn.dataset.chairperson;
            const majorName = btn.dataset.major;
            const minorName = btn.dataset.minor;
            const panelName = btn.dataset.panel;

            teamIdInput.value = teamId;
            modalTitle.innerText = "Assign Panel Members - " + title;

            techSelect.value = techName;
            chairSelect.value = chairName;
            majorSelect.value = majorName;
            minorSelect.value = minorName;
            panelSelect.value = panelName;

            updateOptions();
            modal.style.display = 'flex';
        });
    });

    // Close Modal Logic
    const closeModal = () => modal.style.display = 'none';
    closeModalBtn.addEventListener('click', closeModal);
    cancelModalBtn.addEventListener('click', closeModal);
    window.addEventListener('click', e => { if (e.target === modal) closeModal(); });

    // Disable Same Selection in Dropdowns
    const selects = [techSelect, chairSelect, majorSelect, minorSelect, panelSelect];
    function updateOptions() {
        const selectedValues = selects.map(select => select.value);
        selects.forEach((currentSelect, index) => {
            const otherSelected = selectedValues.filter((_, i) => i !== index);
            Array.from(currentSelect.options).forEach(option => {
                if (option.value === "") return;
                option.disabled = otherSelected.includes(option.value);
            });
        });
    }
    selects.forEach(select => select.addEventListener('change', updateOptions));
</script>

</body>
</html>
