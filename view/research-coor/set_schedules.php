<?php
require $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserType.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Defense Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
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
            grid-template-columns: repeat(7, 1fr); /* 7 days per week */
            gap: 2px;
        }

        .day {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            cursor: pointer;
            user-select: none;
            min-height: 50px;
        }

        .day.weekday {
            font-weight: bold;
            background: #eee;
            cursor: default;
        }

        .day.today {
            background: #ffd700;
        }

        .day.selected {
            background: #4CAF50;
            color: white;
        }

        .day.saved {
            background: #2196F3;
            color: white;
            cursor: not-allowed;
        }

        .day.disabled {
            background: #f0f0f0;
            color: #aaa;
            cursor: not-allowed;
        }

        .set-btn {
            margin: 10px auto;
            display: block;
            padding: 8px 16px;
        }
    </style>
</head>
<body>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>

    <main class="flex-grow-1 p-4">
        <div class="content-page">
            <div class="calendar">
                <h2>Defense Calendar</h2>
                <div class="controls">
                    <select id="monthSelect"></select>
                    <select id="yearSelect"></select>
                </div>
                <div id="days"></div>
                <button class="set-btn" id="saveButton">Save Selected Dates</button>
            </div>
        </div>
    </main>



<script src="/js/manage_schedule.js"></script>
</body>
</html>



