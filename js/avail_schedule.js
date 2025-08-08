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
        fetch(`/actions/get_saved_dates.php?month=${m}&year=${y}`)
            .then(res => res.json())
            .then(data => {
                savedDates = new Set(data);
                renderCalendar(parseInt(yearSelect.value), parseInt(monthSelect.value));
            });
    }

    function reqSchedule() {
        if (selectedModalDate) {
            const form = document.getElementById('scheduleForm');
            form.action = `/actions/add_schedule.php?date=${selectedModalDate}`;
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