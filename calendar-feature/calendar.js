let date = new Date();
let current_day = date.getDate();
let current_month = date.getMonth();
let current_year = date.getYear();

let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
let days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

// populate years for year selection
function createYears(start, end) {
    let years = "";
    for (let year = start; year <= end; year++) {
        years += "<option value='" +
            year + "'>" + year + "</option>";
    }
    return years;
}

// arbitrary range, consider changing later
createYear = createYears(1974, 2074);
document.getElementById("year").innerHTML = createYear;

// navigate to the next month
function nextMonth() {
    if(current_month == 11){
        current_year = current_year + 1;
    }
    current_month = (current_month + 1) % 12;
    updateCalendar(current_month, current_year);
}

// navigate to previous month
function previousMonth() {
    if(current_month == 0){
        current_year = current_year - 1;
        current_month = 11
    }
    else{
        current_month = current_month - 1;
    }
    updateCalendar(current_month, current_year);
}

// navigate to specific date
function setDate(){
    current_month = parseInt(selectMonth.value);
    current_year = parseInt(selectYear.value);
    updateCalendar(current_month, current_year);
}

function updateCalendar(month, year){

}