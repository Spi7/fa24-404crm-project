let notificationFetchInterval;

// Function to toggle the notifications panel
function toggleNotifications() {
    var notificationArea = document.getElementById("notificationArea");

    // Toggle the notification area visibility
    if (notificationArea.style.display === "none" || notificationArea.style.display === "") {
        notificationArea.style.display = "block";
        fetchNotifications();  // Show latest notifications when the panel is opened
    } else {
        notificationArea.style.display = "none";
    }
}

// Function to continuously fetch notifications
function startFetchingNotifications() {
    notificationFetchInterval = setInterval(fetchNotifications, 3000); // 3 seconds
}

// Function to fetch notifications
function fetchNotifications() {
    fetch('fetch_notifications.php', {
        method: 'POST',  // Using POST method even though no data is passed
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',  // Setting the content type
        }
    })
    .then(response => response.json())  // Parse the JSON response from the server
    .then(notifications => {
        console.log('Fetched notifications:', notifications); 
        // Only update the notifications list when the panel is open
        const notificationArea = document.getElementById("notificationArea");
        if (notificationArea.style.display === "block") {
            updateNotifications(notifications);  // Update the UI with the notifications
        }
    })
    .catch(error => console.error('Error fetching notifications:', error));  // Handle any errors
}



// Function to update the notifications list in the UI
function updateNotifications(notifications) {
    const notificationsList = document.getElementById("notificationsList");
    notificationsList.innerHTML = ''; // Clear current notifications

    if (Array.isArray(notifications)) {
        notifications.forEach(notification => {
            let icon = '';
            switch (notification.NOTIFICATION_TYPE) {
                case 'CHATS':
                    icon = "../img/chat-icon.png"; 
                    break;
                case 'INVOICES':
                    icon = "../img/invoice-icon.png"; 
                    break;
                case 'CALENDARS':
                    icon = "../img/calendar-icon.png"; 
                    break;
                case 'PROJECTS':
                    icon = "../img/project-icon.png"; 
                    break;
                default:
                    icon = "../img/404 not found Abous Us.jpg";
            }

            let message = '';
            if (notification.NOTIFICATION_TYPE === 'CHATS') {
                message = "You received a new message!";
            } else if (notification.NOTIFICATION_TYPE === 'CALENDARS') {
                message = "You have a new calendar event scheduled.";
            } else if (notification.NOTIFICATION_TYPE === 'INVOICES') {
                message = "You have a new invoice!";
            } else if (notification.NOTIFICATION_TYPE === 'PROJECTS') {
                message = "You have been assigned to a new project!";
            }

            // Create a new list item for the notification
            const li = document.createElement('li');
            li.innerHTML = `<img src="${icon}" alt="${notification.NOTIFICATION_TYPE}">
                            <p>${message}</p>
                            <p>${new Date(notification.CREATED_AT).toLocaleString()}</p>`;

            // Append the notification to the list
            notificationsList.appendChild(li);
        });
    } else {
        console.error('Notifications are not in the correct format:', notifications);
    }
}

// Start fetching notifications when the page loads
startFetchingNotifications();
