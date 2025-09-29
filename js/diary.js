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
    //modal.addEventListener('close', )

    document.getElementById("prevMonth").addEventListener("click", () => changeMonth(-1));
    document.getElementById("nextMonth").addEventListener("click", () => changeMonth(1));
}

function renderMonth() {
    const currentMonth = document.getElementById("currentMonth");
    currentMonth.innerHTML = ""; //Clear month name
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
    days.innerHTML = ""; //Clear days above the calendar
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
        day.dataset.id = d;

        const label = document.createElement("span");
        label.className = "day-label";
        label.textContent = d;
        day.appendChild(label);

        calendar.appendChild(day);
    }

    const accountID = document.querySelector('main').dataset.accountid;

    //Fetch data of image url, so that it can be loaded into the day's grid while the calendar is loading
    fetch(`../includes/getPHPVariable.php?type=monthDiaries&accountID=${accountID}&year=${year}&month=${month + 1}`)
        .then(res => {
            if (!res.ok) {
                throw new Error(res.statusText);
            }
            return res.json();
        })
        .then(data => {
            data.forEach(entry => {
                // Get day number and insert image url from that day
                const dayNum = parseInt(entry.date.split("-")[2], 10);
                const cell = calendar.querySelector(`.day[data-id='${dayNum}']`);
                if (cell && entry.image_url) {
                    cell.style.backgroundImage = `url("../${entry.image_url}")`;
                    cell.style.backgroundSize = "cover";
                    cell.style.backgroundPosition = "center";
                    cell.classList.add("has-image");
                }
            });
        })
        .catch(err => console.error("Fout bij ophalen monthDiaries:", err));
    }

function changeMonth(offset) {
    today.setMonth(today.getMonth() + offset);
    renderMonth();
    renderCalendar(today.getFullYear(), today.getMonth());
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

    const flexItems = document.createElement("div");
    flexItems.classList.add('modal-flex');
    modalContent.appendChild(flexItems);

    const title = document.createElement("h1");
    flexItems.appendChild(title);

    const closeButton = document.createElement("button");
    closeButton.classList.add('closeButton');
    flexItems.appendChild(closeButton);

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
            // Sets date (Year-month-day) into readable date (Day-month)
            const dateObject = new Date(data[0]['date']);
            const options = { day: 'numeric', month: 'long' };
            const readableDate = dateObject.toLocaleDateString('nl-NL', options);

            title.innerText = readableDate;
            dataEntry.innerText = data[0]['text'];
            image.src = "../" + data[0]['image_url'];
            let audioURL = data[0]['audio_url'];
            modal.showModal();
        })
        .catch(ajaxErrorHandler);
}

function modalClickHandler(e) {
    if(e.target.nodeName === 'DIALOG' || e.target.nodeName === 'BUTTON') {
        modal.close();
    }
}

function capitalizeFirstLetter(val) {
    return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

function ajaxErrorHandler(err) {
    console.log(err);
}