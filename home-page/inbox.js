let notificationFetchInterval;

// Function to toggle the notifications panel
function toggleNotifications() {
    var notificationModal = document.getElementById("notificationModal");

    // Toggle the modal visibility
    if (notificationModal.style.display === "none" || notificationModal.style.display === "") {
        notificationModal.style.display = "block";
        fetchNotifications();  // Show latest notifications when the modal is opened
    } else {
        notificationModal.style.display = "none";
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
        const notificationArea = document.getElementById("notificationModal");
        if (notificationArea.style.display === "block") {
            updateNotifications(notifications);  // Update the UI with the notifications
        }
    })
    .catch(error => console.error('Error fetching notifications:', error));  // Handle any errors
}


function handleSchedulerInvite(notificationId, action) {
    let phpFile = '';
    if (action === 'accept'){
        phpFile = 'accept_scheduler_invite.php'
    }
    else if (action === 'reject'){
        phpFile = 'reject_scheduler_invite.php'
    }

    // Send an AJAX POST request to the PHP file
    fetch(phpFile, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `notification-id=${notificationId}`
    })
        .catch(error => {
            console.error('Error:', error);
        });
}



// Function to update the notifications list in the UI
function updateNotifications(notifications) {
    const notificationsList = document.getElementById("notificationsList");
    notificationsList.innerHTML = ''; // Clear current notifications

    if (Array.isArray(notifications)) {
        notifications.forEach(notification => {
            let icon = '';
            let message = '';
            switch (notification.NOTIFICATION_TYPE) {
                case 'CHATS':
                    icon = "../img/chat-icon.png";
                    message = `${notification.sender_email}: ${notification.message_content}`; 
                    break;
                case 'INVOICES':
                    icon = "../img/invoice-icon.png"; 
                    message = `You have a new invoice from ${notification.sender_email}`;
                    break;
                case 'CALENDARS':
                    icon = "../img/calendar-icon.png"; 
                    message = `You have a new event scheduled with ${notification.sender_email}`;
                    break;
                case 'PROJECTS':
                    icon = "../img/project-icon.png"; 
                    message = `You've been assigned to this project: ${notification.message_content}`;
                    break;
                case 'TEAMS':
                    icon = "../img/project-icon.png"; 
                    message = `You've been assigned to the team: ${notification.message_content}`;
                    break;
                default:
                    icon = "../img/404 not found Abous Us.jpg";
            }

            // Create a new list item for the notification
            const li = document.createElement('li');
            li.innerHTML = `<img src="${icon}" alt="${notification.NOTIFICATION_TYPE}">
                            <p>${message}</p>
                            <p>${new Date(notification.CREATED_AT).toLocaleString()}</p>`;
            if (notification.NOTIFICATION_TYPE === 'CALENDARS'){
                li.innerHTML += `<button class="accept" data-id="${notification.NOTIFICATION_ID}">Accept</button>
                                 <button class="reject" data-id="${notification.NOTIFICATION_ID}">Reject</button>`;

                li.querySelector('.accept').addEventListener('click', function () {
                    handleSchedulerInvite(notification.NOTIFICATION_ID, 'accept');
                });
                li.querySelector('.reject').addEventListener('click', function () {
                    handleSchedulerInvite(notification.NOTIFICATION_ID, 'reject');
                });
            }
            // Append the notification to the list
            notificationsList.appendChild(li);
        });
    } else {
        console.error('Notifications are not in the correct format:', notifications);
    }
}


// When the page loads, ensure the modal is hidden
document.addEventListener("DOMContentLoaded", function() {
    var notificationModal = document.getElementById("notificationModal");
    notificationModal.style.display = "none"; // Hide modal by default
});

// Start fetching notifications when the page loads
startFetchingNotifications();
