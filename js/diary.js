window.addEventListener('load', init);

const daysOfTheWeek = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
let today;

function init() {
    today = new Date();
    renderMonth();
    renderCalendar(today.getFullYear(), today.getMonth());
}

function renderMonth() {
    const currentMonth = document.getElementById("currentMonth");
    const monthName = today.toLocaleString('default', {month: 'long'});
    const monthTitle = document.createElement('h3');
    monthTitle.innerText = capitalizeFirstLetter(monthName);
    currentMonth.appendChild(monthTitle);
}

function renderCalendar(year, month) {
    const days = document.getElementById("days");

    for (let i = 0; i < daysOfTheWeek.length; i++) {
        let dayOfTheWeek = document.createElement("h2");
        dayOfTheWeek.innerText = daysOfTheWeek[i];
        days.appendChild(dayOfTheWeek)
    }

    const calendar = document.getElementById("calendar");
    calendar.innerHTML = ""; // Clear calendar

    const date = new Date(year, month, 1);
    let firstDay = date.getDay();
    firstDay = (firstDay === 0) ? 6 : firstDay - 1;
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    //Create empty tiles before start of month
    for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement("div");
        calendar.appendChild(empty);
    }

    // The actual days in the month
    for (let d = 1; d <= daysInMonth; d++) {
        const day = document.createElement("div");
        day.className = "day";
        day.textContent = d;
        calendar.appendChild(day);
    }
}
function capitalizeFirstLetter(val) {
    return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}