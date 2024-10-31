//an outscope variable to update Enter key on sending messages
let sendMessageListener; //DEclare for "Pressing Enter"
// Function to open chat with the selected contact
function openChat(contactName, contactUserId, email) {
    openChatEmail=email
    // Show chat interface
    document.querySelector('.chat-interface').style.display = 'flex'; 
    document.getElementById('chat-header-text').textContent = `Chat with ${contactName}`;
    document.getElementById('message-input').disabled = false;
    document.querySelector('.send-btn').disabled = false;
    document.getElementById('chat-messages').innerHTML = ''; // Clear previous messages

    //iphone display
    if (window.innerWidth <= 800) { // Adjust the width according to your mobile breakpoint
        isChatOpen = true;
        // For mobile: Show chat interface and hide contact list
        document.querySelector('.contacts').style.display = 'none'; // Hide contacts for mobile
    }
    
     // Fetch initial chat history
     fetchChatHistory(contactUserId);

     // Set an interval to fetch new messages every 2 seconds
     messageFetchInterval = setInterval(() => {
         fetchChatHistory(contactUserId);
     }, 2000); // 2000 ms = 2 seconds
 
    // Set up event listener for sending messages
    const messageInput = document.getElementById('message-input');
     // Remove existing listener if it exists
     if (sendMessageListener) {
        messageInput.removeEventListener('keypress', sendMessageListener);
    }
    // Define the sendMessageListener with the current contactUserId
    sendMessageListener = function(event) {
        if (event.key === 'Enter') {
            sendMessage(contactUserId); // Use the correct user ID
        }
    };

    // Add the new listener
    messageInput.addEventListener('keypress', sendMessageListener);

    // Set up event listener for Send button
    document.getElementById('send-button').addEventListener('click', function() {
        sendMessage(contactUserId);
    });
}

//new function to send message
function sendMessage(contactUserId) {
    let message = document.getElementById('message-input').value; // Get message input

    if (!contactUserId) {
        alert('Chat user ID is not defined.');
        return; // Exit the function if the email is not defined
    }
    if (message) {
        let messageElement = document.createElement('div');
        messageElement.className = 'chat-message sent'; // Add class for styling
        messageElement.innerHTML = `
            <img src="../img/user profile icon.png" alt="User Profile" class="message-profile-pic" />
            <div class="message-content">${message}</div>
        `; // Set message text
        document.getElementById('chat-messages').appendChild(messageElement); // Append message to chat
        // Send message to the backend
        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `other_user_id=${contactUserId}&content=${encodeURIComponent(message)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                alert(data.message); // Show error if message fails
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the message. Please try again. ' + error.message);
        });

        document.getElementById('message-input').value = ''; // Clear input
    }
}

function fetchChatHistory(contactUserId) {
    fetch('fetch_chat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `chat_user_id=${contactUserId}`  // Pass in the current chatting target's user_id
    })
    .then(response => response.json())
    .then(messages => {
        messages.sort((a, b) => a.CHAT_ID - b.CHAT_ID);
        // Clear the chat messages before appending to prevent duplicates
        const chatMessagesContainer = document.getElementById('chat-messages');
        chatMessagesContainer.innerHTML = ''; // Clear previous messages to avoid duplicates

        messages.forEach(message => {
            let messageElement = document.createElement('div');
            if (message.CHAT_USER_ID == contactUserId) {
                messageElement.className = 'chat-message sent'; // Current user's message
                messageElement.innerHTML = `
                    <img src="../img/user profile icon.png" alt="User Profile" class="message-profile-pic" />
                    <div class="message-content">${message.CONTENT}</div>
                `;
            } else {
                messageElement.className = 'chat-message received'; // Other user's message
                messageElement.innerHTML = `
                    <img src="../img/user profile icon.png" alt="User Profile" class="message-profile-pic" />
                    <div class="message-content">${message.CONTENT}</div>
                `;
            }
            chatMessagesContainer.appendChild(messageElement); // Append message
        });
    })
    .catch(error => {
        console.error('Error fetching chat history:', error);
    });
}