<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device=width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>Defense Calendar</title>
    <style>
        .calendar {
            max-width: 600px;
            margin: auto;
        }

        .controls {
            margin: 10px 0;
            text-align: center;
        }

        #days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .day {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            min-height: 50px;
            user-select: none;
        }

        .day.weekday {
            font-weight: bold;
            background: #eee;
            cursor: default;
        }

        .day.today {
            background: #ffd700;
        }

        .day.saved {
            background: #2196F3;
            color: white;
            cursor: pointer;
        }

        .day.disabled {
            background: #f0f0f0;
            color: #aaa;
            cursor: not-allowed;
        }

        .day.empty {
            background: transparent;
            border: none;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }
        
        .calendar {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 340px;
        }

        .calendar header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        }

        select {
        padding: 5px;
        font-size: 1rem;
        }

        .days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        }

        .day {
        text-align: center;
        padding: 10px;
        border-radius: 5px;
        }

        .weekday {
        font-weight: bold;
        background: #eee;
        }

        .today {
        background: #3498db;
        color: white;
        font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>
    <br>
    <main class="flex-grow-1 p-4">
        <div class="content-page">
            <h1 class="text-center mb-4">Defense Calendar</h1>
            <p class="text-center">Select a date to request a schedule for defense.</p>
            <div class="calendar">
                <h2>Defense Calendar</h2>
                <div class="controls">
                    <select id="monthSelect"></select>
                    <select id="yearSelect"></select>
                </div>
                <div id="days"></div>
            </div>

            <!-- Modal -->
            <div id="scheduleModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="modalClose">&times;</span>
                    <h3>Schedule for <span id="modalDate"></span></h3>
                    <p>Request Form for Defense.</p>
                    <form id="scheduleForm" method="POST">

                        <input type="hidden" name="modalDate" id="modalDate">

                        <label>Time:</label>
                        <input type="time" name="timestart" id="timestart"> <br>

                        <input type="hidden" name="team_id" id="team_id">
                        <button onclick="reqSchedule()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<script>
    const monthSelect = document.getElementById('monthSelect');
    const yearSelect = document.getElementById('yearSelect');
    const daysContainer = document.getElementById('days');
    const modal = document.getElementById('scheduleModal');
    const modalDate = document.getElementById('modalDate');
    const modalClose = document.getElementById('modalClose');

    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    let savedDates = new Set();
    let selectedModalDate = null;
    const today = new Date();

    function populateSelectors() {
        months.forEach((month, i) => {
            const opt = new Option(month, i);
            monthSelect.add(opt);
        });

        for (let y = 1970; y <= 2100; y++) {
            const opt = new Option(y, y);
            yearSelect.add(opt);
        }

        const now = new Date();
        monthSelect.value = now.getMonth();
        yearSelect.value = now.getFullYear();
    }

    function formatDate(year, month, day) {
        return `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    }

    function renderCalendar(year, month) {
        daysContainer.innerHTML = "";

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);

        // Weekdays
        weekdays.forEach(wd => {
            const div = document.createElement("div");
            div.className = "day weekday";
            div.innerText = wd;
            daysContainer.appendChild(div);
        });

        // Empty cells before 1st day
        for (let i = 0; i < firstDay.getDay(); i++) {
            const div = document.createElement("div");
            div.className = "day empty";
            daysContainer.appendChild(div);
        }

        for (let d = 1; d <= lastDay.getDate(); d++) {
            const dateStr = formatDate(year, month, d);
            const div = document.createElement("div");
            const current = new Date(year, month, d);
            const isToday = current.toDateString() === today.toDateString();
            const isPast = current < new Date(today.getFullYear(), today.getMonth(), today.getDate());

            div.className = "day";
            div.textContent = d;

            if (isToday) div.classList.add("today");

            if (isPast) {
                div.classList.add("disabled");
            } else if (savedDates.has(dateStr)) {
                div.classList.add("saved");
                div.addEventListener('click', () => {
                    selectedModalDate = dateStr;
                    modalDate.textContent = dateStr;
                    modal.style.display = "block";
                });
            } else {
                div.classList.add("disabled");
            }

            daysContainer.appendChild(div);
        }
    }

    function fetchSavedDates() {
        const y = yearSelect.value;
        const m = parseInt(monthSelect.value) + 1;
        fetch(`get_saved_dates.php?month=${m}&year=${y}`)
            .then(res => res.json())
            .then(data => {
                savedDates = new Set(data);
                renderCalendar(parseInt(yearSelect.value), parseInt(monthSelect.value));
            });
    }

    function reqSchedule() {
        if (selectedModalDate) {
            const form = document.getElementById('scheduleForm');
            form.action = `add_schedule.php?date=${selectedModalDate}`;
            form.submit();
        }
    }


    modalClose.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    monthSelect.addEventListener('change', fetchSavedDates);
    yearSelect.addEventListener('change', fetchSavedDates);

    populateSelectors();
    fetchSavedDates();
</script>

</body>
</html>
