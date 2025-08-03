<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchTeamsDisplay.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Workspace</title>
    <link rel="stylesheet" href="WorkSpace.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
        }
        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>
<body>

<ul>
    <li><a href="#home">Home</a></li>
    <li><a href="#WorkSpace">Workspace</a></li>
    <li><a class="active" href="Manage_Roles.php">Manage Roles</a></li>
    <li><a href="#DefSched">Set Schedule</a></li>
    <li><a href="#GenReport">Generate Report</a></li>
</ul>

<div style="margin-left:25%;padding:1px 16px;height:1000px;">
    <h1>Workspace</h1><br>
    <h3>Capstone Teams</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Authors</th>
                <th>Adviser</th>
                <th>Research Type</th>
                <th>Chairperson</th>
                <th>Major Discipline</th>
                <th>Minor Discipline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($user_is_on_team)): ?>
                <?php foreach ($user_is_on_team as $team): ?>
                    <tr>
                        <td><?= htmlspecialchars($team['title']) ?></td>
                        <td>
                            <?php
                            if (!empty($members_by_team[$team_id])) {
                                foreach ($members_by_team[$team_id] as $member) {
                                    echo htmlspecialchars($member) . "<br>";
                                }
                            } else {
                                echo "No members found.";
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($team['adviser']) ?></td>
                        <td><?= htmlspecialchars($team['research_progress']) ?></td>
                        <td><?= htmlspecialchars($team['chairperson']) ?><br></td>
                        <td><?= htmlspecialchars($team['major_disc']) ?><br></td>
                        <td><?= htmlspecialchars($team['minor_disc']) ?><br></td>
                        <td>
                            <button 
                                type="button" 
                                class="btn-primary-sm openModalBtn"
                                data-team-id="<?= htmlspecialchars($team['team_id']) ?>"
                                data-title="<?= htmlspecialchars($team['title']) ?>"
                                data-chairperson="<?= htmlspecialchars($team['chairperson']) ?>"
                                data-major="<?= htmlspecialchars($team['major_disc']) ?>"
                                data-minor="<?= htmlspecialchars($team['minor_disc']) ?>"
                            >
                                Assign Panelists
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

        <form action="../Actions/Roles_Assign_Submit.php" method="POST">
            <input type="hidden" name="team_id" id="modalTeamId">

            <label>Chair Person:</label><br>
            <select name="chairperson" id="modalChairperson" required>
                <option value="">Select Chair Person</option>
                <?php foreach ($faculty as $id => $name): ?>
                    <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label>Major Discipline:</label><br>
            <select name="major_disc" id="modalMajor" required>
                <option value="">Select Major Discipline</option>
                <?php foreach ($faculty as $id => $name): ?>
                    <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label>Minor Discipline:</label><br>
            <select name="minor_disc" id="modalMinor" required>
                <option value="">Select Minor Discipline</option>
                <?php foreach ($faculty as $id => $name): ?>
                    <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <button type="submit" class="btn-primary-sm">Assign Panel</button>
            <button type="button" id="cancelModalBtn" class="btn-secondary-sm">Cancel</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('assignModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const openButtons = document.querySelectorAll('.openModalBtn');

    const teamIdInput = document.getElementById('modalTeamId');
    const chairSelect = document.getElementById('modalChairperson');
    const majorSelect = document.getElementById('modalMajor');
    const minorSelect = document.getElementById('modalMinor');
    const modalTitle = document.getElementById('modalTitle');

    // Open Modal & Populate Data
    openButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const teamId = btn.dataset.teamId;
            const title = btn.dataset.title;
            const chairName = btn.dataset.chairperson;
            const majorName = btn.dataset.major;
            const minorName = btn.dataset.minor;

            teamIdInput.value = teamId;
            modalTitle.innerText = "Assign Panel Members - " + title;

            chairSelect.value = chairName;
            majorSelect.value = majorName;
            minorSelect.value = minorName;

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
    const selects = [chairSelect, majorSelect, minorSelect];
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
