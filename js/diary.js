window.addEventListener('load', init);

const daysOfTheWeek = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
let today;
let calendar;
let modal;
let modalContent;

function init() {
    //Today's date & rendering calendar with real-time data
    today = new Date();
    renderMonth();
    renderCalendar(today.getFullYear(), today.getMonth());

    modalContent = document.querySelector(".modalContent");
    modal = document.querySelector(".modal");

    calendar.addEventListener('click', checkDate);
    modal.addEventListener('click', modalClickHandler);
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

    calendar = document.getElementById("calendar");
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
        day.dataset.id = d;
        calendar.appendChild(day);
    }
}

function checkDate(e) {
    e.preventDefault();

    if(e.target.classList.contains("day")) {
        //Open dialog modal & send data from clicked item with
        showModal(e.target.dataset.id);
    }
}

function showModal(date) {
    modalContent.innerHTML = '';

    const title = document.createElement("h1");
    modalContent.appendChild(title);

    const dataEntry = document.createElement("p");
    modalContent.appendChild(dataEntry);

    const image = document.createElement("img");
    image.alt = "Day's photo";
    modalContent.appendChild(image);

    const accountID = document.querySelector('main').dataset.accountid;

    // Get current diary from database
    fetch(`../includes/getPHPVariable.php?type=diary&dayID=${date}&accountID=${accountID}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            // Get name from retrieved object (need to specify 0, as data is an array, but with
            // only one item, so we need the 'first' entry in the array.
            title.innerText = data[0]['date'];
            dataEntry.innerText = data[0]['text'];
            image.src = "../" + data[0]['image_url'];
            let audioURL = data[0]['audio_url'];
            modal.showModal();
        })
        .catch(ajaxErrorHandler);
}

function modalClickHandler(e) {
    if(e.target.nodeName === 'DIALOG') {
        modal.close();
    }
}

function capitalizeFirstLetter(val) {
    return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

function ajaxErrorHandler(err) {
    console.log(err);
}