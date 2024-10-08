// Function to add a new contact
// Function to add a new contact
function addNewContact() {
    let contactList = document.getElementById('contact-list');
    let newContactEmail = prompt("Enter contact email:"); // Prompt for email input

    // Validate email format
    if (newContactEmail && validateEmail(newContactEmail)) {
        // For now, set a placeholder for the profile picture and nickname
        const profilePic = '../img/user profile icon.png'; // In future, change to a path/database fetch img --> 'path/to/default/profile-pic.png'
        const nickname = newContactEmail.split('@')[0]; // Default nickname as the email prefix
        
        let listItem = document.createElement('li');
        listItem.innerHTML = `
            <img src="${profilePic}" alt="${nickname}" class="profile-pic" />
            <span class="contact-nickname">${nickname}</span>
            <span class="contact-email">${newContactEmail}</span>
        `;
        listItem.onclick = function() {
            openChat(nickname); // Open chat on click
        };
        contactList.appendChild(listItem); // Add the contact to the list
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