// Function to add a new contact

// Validate email format
function addNewContact() {
    let contactList = document.getElementById('contact-list');
    let noContactsMessage = document.getElementById('no-contacts-message'); // no contact found message
    let newContactEmail = prompt("Enter contact email:"); // Prompt for email input

    // Validate email format
    if (newContactEmail && validateEmail(newContactEmail)) {
        console.log('Adding contact:', newContactEmail); // Log the email being added

        fetch('add_contact_backend.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'email=' + encodeURIComponent(newContactEmail)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            // Handle the response from the server
            if (data.status === 'success') {
                const profilePic = '../img/user profile icon.png'; // Default profile picture
                const nickname = data.nickname; // nickname fetch by data from ajax

                if (noContactsMessage) {
                    noContactsMessage.style.display = 'none'; // Hide the no contact found message
                }

                let listItem = document.createElement('li');
                listItem.innerHTML = `
                    <img src="${profilePic}" alt="${nickname}" class="profile-pic" />
                    <span class="contact-nickname">${nickname}</span>
                    <span class="contact-email">${newContactEmail}</span>
                    <button class="delete-contact-btn" onclick="deleteContact('${newContactEmail}')">X</button>
                `;
                
                // Set onclick event to open chat
                listItem.onclick = function() {
                    openChat(nickname); // Open chat on click
                };
                
                contactList.appendChild(listItem); // Add the contact to the list
                // alert(data.message); // Show success message
            } else {
                alert(data.message); // Show error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the contact. Please try again. ' + error.message); // Show detailed error message
        });
    } else {
        alert('Please enter a valid email address.');
    }
}

// Function to validate email format (simple regex) --> later on, fetch it from database to validate if the user exist
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Function to open chat with the selected contact
function openChat(contactName) {
    if (window.innerWidth <= 768) { // Adjust the width according to your mobile breakpoint
        // For mobile: Show chat interface and hide contact list
        document.querySelector('.contacts').style.display = 'none'; // Hide contacts
        document.querySelector('.chat-interface').style.display = 'flex'; // Show chat
    }
    // For desktop: Keep the existing behavior
    document.getElementById('chat-header-text').textContent = `Chat with ${contactName}`;
    document.getElementById('message-input').disabled = false;
    document.querySelector('.send-btn').disabled = false;
    document.getElementById('chat-messages').innerHTML = '';

    document.getElementById('message-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });
}

// Function to send a message
function sendMessage() {
    let message = document.getElementById('message-input').value; // Get message input
    if (message) {
        let messageElement = document.createElement('div');
        messageElement.className = 'chat-message sent'; // Add class for styling
        messageElement.innerHTML = `
            <img src="../img/user profile icon.png" alt="User Profile" class="message-profile-pic" />
            <div class="message-content">${message}</div>
        `; // Set message text
        document.getElementById('chat-messages').appendChild(messageElement); // Append message to chat
        document.getElementById('message-input').value = ''; // Clear input
    }
}