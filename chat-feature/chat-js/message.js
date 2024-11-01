// Get the file input and message input elements 
const fileInput = document.getElementById('file-input');
const messageInput = document.getElementById('message-input');

// Add an event listener to the file input
fileInput.addEventListener('change', function() {
    const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : '';
    messageInput.value = fileName; // Set the message input value to the file name
});

// An outscope variable to update Enter key on sending messages

let sendMessageListener; //DEclare for "Pressing Enter"
let messageFetchInterval
// Function to open chat with the selected contact
function openChat(contactName, contactUserId, email) {
    clearInterval(messageFetchInterval)
    openChatEmail=email
    // Show chat interface
    document.querySelector('.chat-interface').style.display = 'flex';
    document.getElementById('chat-header-text').textContent = `Chat with ${contactName}`;
    document.getElementById('message-input').disabled = false;
    document.querySelector('.send-btn').disabled = false;
    document.getElementById('attach-btn').disabled = false;
    document.getElementById('chat-messages').innerHTML = ''; // Clear previous messages

    // iPhone display
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
    }, 3000); // 3000 ms = 3 seconds

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

function sendMessage(contactUserId) {
    let message = document.getElementById('message-input').value; // Get message input
    let fileInput = document.getElementById('file-input'); // Get file input
    let formData = new FormData(); // Create a FormData object to send files

    if (!contactUserId) {
        alert('Chat user ID is not defined.');
        return; // Exit the function if the ID is not defined
    }

    if (message || fileInput.files.length > 0) {
        // Append the message and file to the FormData object
        formData.append('other_user_id', contactUserId);
        formData.append('content', message);
        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]); // Add the file to FormData
        }

        // Send message and file to the backend
        fetch('send_message.php', {
            method: 'POST',
            body: formData // Send FormData as the body
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                alert(data.message); // Show error if message fails
            } else {
                // Display sent message
                let messageElement = document.createElement('div');
                messageElement.className = 'chat-message sent'; // Add class for styling
                messageElement.innerHTML = `
                    <img src="../img/user profile icon.png" alt="User Profile" class="message-profile-pic" />
                    <div class="message-content">${message}</div>
                `; // Set message text
                document.getElementById('chat-messages').appendChild(messageElement); // Append message to chat

                // Handle file display if uploaded
                if (data.file_path) {
                    if (data.is_image) {
                        // Create an image element if the uploaded file is an image
                        let imgElement = document.createElement('img');
                        imgElement.src = data.file_path; // Set the image source
                        imgElement.alt = 'Sent Image';
                        imgElement.className = 'message-image'; // Add your styles if needed
                        messageElement.appendChild(imgElement); // Append the image element
                    } else {
                        // Handle non-image files
                        let fileElement = document.createElement('a');
                        fileElement.href = data.file_path; // Link to the uploaded file
                        fileElement.textContent = 'Open File'; // Change this based on the file type
                        fileElement.target = '_blank'; // Open in a new tab
                        messageElement.appendChild(fileElement); // Append file link to message
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the message. Please try again. ' + error.message);
        });

        document.getElementById('message-input').value = ''; // Clear input
        fileInput.value = ''; // Clear file input
    }
}

function fetchChatHistory(contactUserId) {
    fetch('fetch_chat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `chat_user_id=${contactUserId}`
    })
    .then(response => response.json())
    .then(messages => {
        document.getElementById('chat-messages').innerHTML = ''; // Clear previous messages to prevent duplicates
        messages.forEach(message => {
            let messageElement = document.createElement('div');
            // Logic to differentiate between sent and received messages
            messageElement.className = (message.CHAT_USER_ID == contactUserId) ? 'chat-message sent' : 'chat-message received';

            // Build the message content
            messageElement.innerHTML = `
                <img src="../img/user profile icon.png" alt="User Profile" class="message-profile-pic" />
                <div class="message-content">${message.CONTENT}</div>
            `;

            // Check if there is a file path and display accordingly
            if (message.FILE_PATH) {
                const fileType = message.FILE_PATH.split('.').pop().toLowerCase(); // Get the file extension
                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                    // If the file is an image
                    let imgElement = document.createElement('img');
                    imgElement.src = message.FILE_PATH; // Set the image source
                    imgElement.alt = 'Sent Image';
                    imgElement.className = 'message-image'; // Add your styles if needed
                    messageElement.appendChild(imgElement); // Append the image element
                } else {
                    // For other file types like PDF
                    let fileElement = document.createElement('a');
                    fileElement.href = message.FILE_PATH; // Use the file path from the message
                    fileElement.textContent = 'Open File'; // Link text
                    fileElement.target = '_blank'; // Open in a new tab
                    messageElement.appendChild(fileElement); // Append file link to message
                }
            }

            document.getElementById('chat-messages').appendChild(messageElement);
        });
    })
    .catch(error => console.error('Error fetching chat history:', error));
}