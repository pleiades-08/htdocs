<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchStudentTeam.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device=width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>Defense Calendar</title>
    <style>
        .calendar {
            width: 80%;
        }
        .def-tbl {
            width: 100%;
        }
        .controls {
            margin: 10px 0;
            text-align: center;
            display: flex;
            gap: 5px;
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
            background: #74c476;
            color: white;
            cursor: pointer;
        }
        .day.saved:hover {
            background: white;
            color: #74c476;
            border: solid 1px #74c476;
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
        .def-calendar {
            width: 100%;
            height: auto;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>
    <br>
    <main class="flex-grow-1 p-4">
        <div class="content-page">            
            <div class="def-calendar">
                <!-- Calendar -->
                <div class="calendar">
                    <h2>Defense Calendar</h2>
                    <p class="text-center">Click a date to view schedules.</p>
                    <div class="controls">
                        <select class="form-select" id="monthSelect"></select>
                        <select class="form-select" id="yearSelect"></select>
                    </div>
                    <div id="days"></div>
                </div>

                <!-- Schedule Table -->
                <div class="def-tbl">
                    <h2>Schedules for :</h2>
                    <p class="text-center">Scheduled of incoming Defense.</p>
                    <table class="table align-middle table-striped table-hover mb-4 data_table" id="activeTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Adviser</th>
                                <th scope="col">Members</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center">Select a date to view schedules</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

<script>
    const monthSelect = document.getElementById('monthSelect');
    const yearSelect = document.getElementById('yearSelect');
    const daysContainer = document.getElementById('days');

    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    let savedDates = new Set();
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

        // Weekdays header
        weekdays.forEach(wd => {
            const div = document.createElement("div");
            div.className = "day weekday";
            div.innerText = wd;
            daysContainer.appendChild(div);
        });

        // Empty slots before the first day
        for (let i = 0; i < firstDay.getDay(); i++) {
            const div = document.createElement("div");
            div.className = "day empty";
            daysContainer.appendChild(div);
        }

        // Days
        for (let d = 1; d <= lastDay.getDate(); d++) {
            const dateStr = formatDate(year, month, d);
            const div = document.createElement("div");
            const current = new Date(year, month, d);
            const isToday = current.toDateString() === today.toDateString();
            const isPast = current < new Date(today.getFullYear(), today.getMonth(), today.getDate());
            div.className = "day";
            div.textContent = d;
            if (isToday) div.classList.add("today");

            if (savedDates.has(dateStr)) {
                div.classList.add("saved");
                div.addEventListener('click', () => loadSchedules(dateStr));
            } else {
                div.classList.add("disabled");
            }

            daysContainer.appendChild(div);
        }
    }

    function fetchSavedDates() {
        const y = yearSelect.value;
        const m = parseInt(monthSelect.value) + 1;
        fetch(`/actions/get_saved_dates.php?month=${m}&year=${y}`)
            .then(res => res.json())
            .then(data => {
                savedDates = new Set(data);
                renderCalendar(parseInt(yearSelect.value), parseInt(monthSelect.value));
            });
    }

    function loadSchedules(date) {
        fetch(`/actions/get_schedules.php?date=${date}`)
            .then(res => res.json())
            .then(data => {
                const tableBody = document.querySelector('#activeTable tbody');
                tableBody.innerHTML = ""; // Clear previous rows

                if (data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No schedules for ${date}</td></tr>`;
                    return;
                }

                data.forEach((schedule, index) => {
                    const row = `
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${schedule.capstone_title}</td>
                            <td>${schedule.adviser_name}</td>
                            <td>${schedule.members}</td>
                            <td>${schedule.def_time}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            })
            .catch(err => console.error(err));
    }

    monthSelect.addEventListener('change', fetchSavedDates);
    yearSelect.addEventListener('change', fetchSavedDates);

    populateSelectors();
    fetchSavedDates();
</script>

</body>
</html>
