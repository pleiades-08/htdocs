const monthSelect = document.getElementById('monthSelect');
const yearSelect = document.getElementById('yearSelect');
const daysContainer = document.getElementById('days');
const saveButton = document.getElementById('saveButton');

const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];
const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

let selectedDates = new Set();
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

    weekdays.forEach(wd => {
        const div = document.createElement("div");
        div.className = "day weekday";
        div.innerText = wd;
        daysContainer.appendChild(div);
    });

    for (let i = 0; i < firstDay.getDay(); i++) {
        const div = document.createElement("div");
        div.className = "day empty";
        daysContainer.appendChild(div);
    }

    for (let d = 1; d <= lastDay.getDate(); d++) {
        const dateStr = formatDate(year, month, d);
        const div = document.createElement("div");
        div.className = "day";
        div.textContent = d;

        const current = new Date(year, month, d);
        const isToday = current.toDateString() === today.toDateString();
        const isPast = current < new Date(today.getFullYear(), today.getMonth(), today.getDate());

        if (isToday) div.classList.add("today");
        if (isPast) {
            div.classList.add("disabled");
        } else if (savedDates.has(dateStr)) {
            div.classList.add("saved");
        } else {
            div.addEventListener('click', () => {
                if (selectedDates.has(dateStr)) {
                    selectedDates.delete(dateStr);
                    div.classList.remove("selected");
                } else {
                    selectedDates.add(dateStr);
                    div.classList.add("selected");
                }
            });
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
            selectedDates.clear();
            renderCalendar(parseInt(yearSelect.value), parseInt(monthSelect.value));
        });
}

saveButton.addEventListener('click', () => {
    if (selectedDates.size === 0) return alert("No dates selected.");
    fetch('/actions/save_dates.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ dates: [...selectedDates] })
    })
    .then(res => res.text())
    .then(msg => {
        alert(msg);
        fetchSavedDates();
    });
});

monthSelect.addEventListener('change', fetchSavedDates);
yearSelect.addEventListener('change', fetchSavedDates);

populateSelectors();
fetchSavedDates();