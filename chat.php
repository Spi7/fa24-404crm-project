<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Server</title>
    <link rel="stylesheet" href="css/chat.css">
</head>
<body>
    <div class="chat-container">
        <!-- Sidebar (You can style this later, leaving it as a placeholder) -->
        <?php include 'sidebar.php'; ?>

        <!-- Contacts Section -->
        <div class="contacts">
            <h3>
                Contacts
            </h3>
            <ul id="contact-list">
                <!-- Initially, this will be empty. JavaScript can be used to dynamically add contacts -->
            </ul>
            <!-- Add Contact Button -->
            <button class="add-contact-btn" onclick="addNewContact()">+ Add Contact</button>
        </div>

        <!-- Chat Section -->
        <div class="chat-interface">
            <div class="chat-header">
                <h3 id="chat-header-text">Select a contact to start chatting</h3>
            </div>
            <div class="chat-messages" id="chat-messages">
                <!-- Chat messages will appear here dynamically -->
            </div>
            <div class="chat-input">
                <input type="text" id="message-input" placeholder="Type a message" disabled>
                <button class="attach-btn" onclick="attachFile()">
                    <img src="img/attachment.png" alt="Attach" class="attach-icon"> <!-- Add attachment icon -->
                </button>
                <button class="send-btn" onclick="sendMessage()" disabled>Send</button>
            </div>
        </div>
    </div>

    <script>
        function addNewContact() {
            let contactList = document.getElementById('contact-list');
            let newContact = prompt("Enter contact name:");
            if (newContact) {
                let listItem = document.createElement('li');
                listItem.innerHTML = newContact;
                listItem.onclick = function() {
                    openChat(newContact);
                };
                contactList.appendChild(listItem);
            }
        }

        function openChat(contactName) {
            document.getElementById('chat-header-text').textContent = contactName;
            document.getElementById('message-input').disabled = false;
            document.querySelector('.send-btn').disabled = false;
            document.getElementById('chat-messages').innerHTML = ''; // Clear previous chat history
        }

        function sendMessage() {
            let message = document.getElementById('message-input').value;
            if (message) {
                let messageElement = document.createElement('div');
                messageElement.className = 'chat-message sent';
                messageElement.innerHTML = message;
                document.getElementById('chat-messages').appendChild(messageElement);
                document.getElementById('message-input').value = ''; // Clear input
            }
        }
    </script>
</body>
</html>
