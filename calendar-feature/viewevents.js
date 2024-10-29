const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

document.addEventListener('DOMContentLoaded', () => {populateEvents();});

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
    let month = window.month;
    let year = Number(window.year);
    let monthIndex = months.indexOf(month);
    let stackEvents = document.getElementById('stack-events');
    fetchEvents().then(events => {
        events.forEach(event => {
            let startDate = new Date(event.EVENT_START);
            let eventYear = startDate.getFullYear();
            let eventMonth = startDate.getMonth();
            if(eventMonth != monthIndex || eventYear != year){
                return;
            }
            let endDate = new Date(event.EVENT_END)
            let title = event.TITLE;
            let description = event.EVENT_DESCRIPTION;
            let repeat = event.FREQUENCY;
            let allday = parseInt(event.ALL_DAY);

            let eventText = "Title: "+title+"<br>Description: "+description+"<br>";
            if (allday == 0){
                eventText += "Start: "+startDate.toLocaleString()+"<br>End: "+endDate.toLocaleString()+"<br>";
            }
            else{
                eventText += "All Day: "+startDate.toLocaleString()+"<br>";
            }
            eventText += "Repeat: "+repeat;
            let eventDiv = document.createElement('div');
            eventDiv.className = 'event';
            eventDiv.style.backgroundColor = event.COLOR;
            eventDiv.innerHTML = eventText;
            event.id = startDate.toISOString();
            stackEvents.appendChild(eventDiv);
        });
    })
    sortEvents(stackEvents);
}

function sortEvents(container){
    let events = Array.from(container.querySelectorAll('.event'));
    if(events.length < 2){
        return;
    }
    events.sort((a, b) => {
        const textA = a.id; 
        const textB = b.id;
        return textA.localeCompare(textB); 
    });
    container.innerHTML = ''; 
    events.forEach(eventDiv => {
        container.appendChild(eventDiv);
    });
}
