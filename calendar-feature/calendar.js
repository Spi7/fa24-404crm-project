const monthDays = {
    'January': 31,
    'February': 28,
    'March': 31,
    'April': 30,
    'May': 31,
    'June': 30,
    'July': 31,
    'August': 31,
    'September': 30,
    'October': 31,
    'November': 30,
    'December': 31
};

const months = Object.keys(monthDays);

document.getElementById('set-date').addEventListener('click', () => selectDate());
document.getElementById('prev-month').addEventListener('click', () => prevMonth());
document.getElementById('next-month').addEventListener('click', () => nextMonth());
document.addEventListener('DOMContentLoaded', highlightCurrDay);
document.addEventListener('DOMContentLoaded', populateEvents);

function prevMonth() {
    let monthText = document.querySelector('h1.month').textContent;
    let [month, year] = monthText.split(' ');
    year = Number(year);
    
    let prevMonthIndex = months.indexOf(month) - 1;

    if (prevMonthIndex < 0) {
        prevMonthIndex = 11; 
        year--; 
    }

    let prevMonth = months[prevMonthIndex];
    let daysInPrevMonth = monthDays[prevMonth];

    let twoPrevMonth;
    if (prevMonthIndex == 0){
        twoPrevMonth = months[11]
    }
    else{
        twoPrevMonth = months[prevMonthIndex-1]
    }
    twoPrevMonthDays = monthDays[twoPrevMonth];

    if (prevMonth === 'February' && (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0))) {
        daysInPrevMonth++;
    }

    const calendarGrid = document.getElementById('calendar-grid');

    while (calendarGrid.firstChild) {
        calendarGrid.removeChild(calendarGrid.firstChild);
    }

    const currentMonthIndex = months.indexOf(month);
    let firstDayOfCurrentMonth = new Date(year, prevMonthIndex, 1);
    let firstDayIndex = firstDayOfCurrentMonth.getDay(); 

    for (let i = twoPrevMonthDays - firstDayIndex; i < twoPrevMonthDays; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i + 1; 
        calendarGrid.appendChild(newDayBox);
    }

    for (let i = 1; i <= daysInPrevMonth; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i;
        calendarGrid.appendChild(newDayBox);
    }

    let nextMonthIndex = (prevMonthIndex + 1) % 12; 
    let daysInNextMonth = monthDays[months[nextMonthIndex]];

    if (months[nextMonthIndex] === 'February' && (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0))) {
        daysInNextMonth++;
    }

    let maxLength = 35;
    calendarGrid.style.gridTemplateRows = 'repeat(5, 1fr)';
    if(calendarGrid.children.length > 35){
        maxLength = 42;
        calendarGrid.style.gridTemplateRows = 'repeat(6, 1fr)';
    }

    for (let i = 1; calendarGrid.children.length < maxLength; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i; 
        calendarGrid.appendChild(newDayBox);
    }

    document.querySelector('h1.month').textContent = prevMonth + " " + year;
    highlightCurrDay();
}

function nextMonth() {
    let monthText = document.querySelector('h1.month').textContent;
    let [month, year] = monthText.split(' ');
    year = Number(year);
    
    let nextMonthIndex = months.indexOf(month) + 1;

    if (nextMonthIndex > 11) {
        nextMonthIndex = 0; 
        year++; 
    }

    let nextMonth = months[nextMonthIndex];
    let daysInNextMonth = monthDays[nextMonth];


    if (nextMonth === 'February' && (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0))) {
        daysInNextMonth++;
    }

    let prevMonthIndex = (nextMonthIndex - 1 + 12) % 12; 
    let prevMonth = months[prevMonthIndex];
    let daysInPrevMonth = monthDays[prevMonth];

    if (nextMonth === 'February' && (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0))) {
        daysInPrevMonth++; 
    }

    const calendarGrid = document.getElementById('calendar-grid');

    while (calendarGrid.firstChild) {
        calendarGrid.removeChild(calendarGrid.firstChild);
    }

    let firstDayOfNextMonth = new Date(year, nextMonthIndex, 1);
    let firstDayIndex = firstDayOfNextMonth.getDay(); 

    for (let i = daysInPrevMonth - firstDayIndex; i < daysInPrevMonth; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i + 1; 
        calendarGrid.appendChild(newDayBox);
    }

    for (let i = 1; i <= daysInNextMonth; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i;
        calendarGrid.appendChild(newDayBox);
    }

    let followingMonthIndex = (nextMonthIndex + 1) % 12; 
    let daysInFollowingMonth = monthDays[months[followingMonthIndex]];

    if (months[followingMonthIndex] === 'February' && (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0))) {
        daysInFollowingMonth++;
    }

    let maxLength = 35;
    calendarGrid.style.gridTemplateRows = 'repeat(5, 1fr)';
    if(calendarGrid.children.length > 35){
        maxLength = 42;
        calendarGrid.style.gridTemplateRows = 'repeat(6, 1fr)';
    }

    for (let i = 1; calendarGrid.children.length < maxLength; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i; 
        calendarGrid.appendChild(newDayBox);
    }

    document.querySelector('h1.month').textContent = nextMonth + " " + year;
    highlightCurrDay();
}

function selectDate() {

    let dateInput = document.getElementById('select-date').value;
    let dateEntered = new Date(dateInput);

    let month = dateEntered.getMonth();
    let year = dateEntered.getFullYear();
    let prevMonthIndex = month;


    let prevMonth = months[prevMonthIndex];
    let daysInPrevMonth = monthDays[prevMonth];

    let twoPrevMonth;
    if (prevMonthIndex == 0){
        twoPrevMonth = months[11]
    }
    else{
        twoPrevMonth = months[prevMonthIndex-1]
    }
    twoPrevMonthDays = monthDays[twoPrevMonth];

    if (prevMonth === 'February' && (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0))) {
        daysInPrevMonth++;
    }

    const calendarGrid = document.getElementById('calendar-grid');

    while (calendarGrid.firstChild) {
        calendarGrid.removeChild(calendarGrid.firstChild);
    }

    const currentMonthIndex = months.indexOf(month);
    let firstDayOfCurrentMonth = new Date(year, prevMonthIndex, 1);
    let firstDayIndex = firstDayOfCurrentMonth.getDay(); 

    for (let i = twoPrevMonthDays - firstDayIndex; i < twoPrevMonthDays; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i + 1; 
        calendarGrid.appendChild(newDayBox);
    }

    for (let i = 1; i <= daysInPrevMonth; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i;
        calendarGrid.appendChild(newDayBox);
    }

    let nextMonthIndex = (prevMonthIndex + 1) % 12; 
    let daysInNextMonth = monthDays[months[nextMonthIndex]];

    if (months[nextMonthIndex] === 'February' && (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0))) {
        daysInNextMonth++;
    }

    let maxLength = 35;
    calendarGrid.style.gridTemplateRows = 'repeat(5, 1fr)';
    if(calendarGrid.children.length > 35){
        maxLength = 42;
        calendarGrid.style.gridTemplateRows = 'repeat(6, 1fr)';
    }

    for (let i = 1; calendarGrid.children.length < maxLength; i++) {
        let newDayBox = document.createElement('div');
        newDayBox.className = 'day-box';
        newDayBox.textContent = i; 
        calendarGrid.appendChild(newDayBox);
    }

    document.querySelector('h1.month').textContent = prevMonth + " " + year;
    highlightCurrDay();
}

function highlightCurrDay(){
    let currDate = new Date();
    let currYear = currDate.getFullYear();
    let currMonth = currDate.getMonth();
    let currDay = currDate.getDate();

    let monthText = document.querySelector('h1.month').textContent;
    let [month, year] = monthText.split(' ');
    monthIndex = months.indexOf(month);
    if(Number(year) == currYear && currMonth == monthIndex){
        const calendarGrid = document.getElementById('calendar-grid');
        const dayboxes = calendarGrid.querySelectorAll('.day-box');
        dayboxes.forEach(daybox => {
            if(Number(daybox.textContent.trim()) == currDay){
                daybox.style.backgroundColor = 'yellow';
            }
        });
    }
}

function fetchEvents(){
    return fetch('fetchevents.php').then(response => {
        if(response.ok){
            return response.json();
        }else {
            throw new Error('Network response was not ok');
        }
    }).then(data => {
        if(!data.error){
            return data;
        }else {
            console.error('Error from server:', data.error); 
            throw new Error(data.error);
        }
    }).catch(error =>{
        console.error('There was a problem with the fetch operation:', error);
        throw error;
    })
}

function populateEvents(){
    let monthText = document.querySelector('h1.month').textContent;
    let [month, year] = monthText.split(' ');
    year = Number(year);
    let monthIndex = months.indexOf(month);
    const calendarGrid = document.getElementById('calendar-grid');
    const dayboxes = calendarGrid.querySelectorAll('.day-box');

    fetchEvents().then(events => {
        events.forEach(event => {
            let eventDate = new Date(event.EVENT_START);
            let eventYear = eventDate.getFullYear();
            let eventMonth = eventDate.getMonth();
            let eventDay = eventDate.getDate();
            if(Number(year) == eventYear && eventMonth == monthIndex){
                dayboxes.forEach(daybox => {
                    if(Number(daybox.textContent.slice(0,2)) == eventDay){
                        let eventDiv = document.createElement('div');
                        eventDiv.className = 'event';
                        eventDiv.style.backgroundColor = event.COLOR;
                        eventDiv.textContent = event.TITLE;
                        eventDiv.id = event.EVENT_ID;
                        daybox.appendChild(eventDiv);
                    }
                })
            }
        })
    }).catch(error => {
        console.error('Error fetching events:', error);
    })
}
