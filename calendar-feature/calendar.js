let date = new Date();
let current_day = date.getDate();
let current_month = date.getMonth();
let current_year = date.getYear();

let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
let days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

// navigate to the next month
function nextMonth() {
    if(current_month == 11){
        current_year = current_year + 1;
    }
    current_month = (current_month + 1) % 12;
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
}

// navigate to specific date
function setDate(day, month, year){
    current_day = day;
    current_month = month;
    current_year = year;
}