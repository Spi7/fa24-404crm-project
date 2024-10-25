// Function to add a new contact
let isChatOpen = false; //keep track chat UI for mobile
// Validate email format
function addNewContact() {
    let contactList = document.getElementById('contact-list');
    let noContactsMessage = document.getElementById('no-contacts-message'); // no contact found message
    let newContactEmail = prompt("Enter contact email:"); // Prompt for email input

    // Validate email format
    if (newContactEmail && validateEmail(newContactEmail)) {

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
                listItem.className = 'contact-item';
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

                //update new contact list
                updateContactsArray();
                //Call filterContact
                filterContacts();
            } else {
                alert(data.message); // Show error message if it's added unsuccessfully
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

// Function to update contacts array
function updateContactsArray() {
    const contactList = document.getElementById('contact-list');
    contacts = Array.from(contactList.getElementsByClassName('contact-item')); // Refresh the contacts array
}

// Function to validate email format (simple regex) --> later on, fetch it from database to validate if the user exist
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Function to open chat with the selected contact
function openChat(contactName) {
    // For desktop: Keep the existing behavior
    document.querySelector('.chat-interface').style.display = 'flex'; // Show chat
    document.getElementById('chat-header-text').textContent = `Chat with ${contactName}`;
    document.getElementById('message-input').disabled = false;
    document.querySelector('.send-btn').disabled = false;
    document.getElementById('chat-messages').innerHTML = '';
    if (window.innerWidth <= 768) { // Adjust the width according to your mobile breakpoint
        isChatOpen = true;
        // For mobile: Show chat interface and hide contact list
        document.querySelector('.contacts').style.display = 'none'; // Hide contacts for mobile
    }

    document.getElementById('message-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });
}

function goBack() {
    if (window.innerWidth <= 768) { // Mobile behavior
        if (isChatOpen) {
            // If in chat, go back to contacts
            isChatOpen = false;
            showContacts();
        }
    } 
}

function showContacts() {
    isChatOpen = false;
    document.querySelector('.contacts').style.display = 'flex'; // Show contacts
    document.querySelector('.chat-interface').style.display = 'none'; // Hide chat
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