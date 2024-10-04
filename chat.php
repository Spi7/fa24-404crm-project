<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Server</title>
    <link rel="stylesheet" href="css/chat.css">
    <script>
        // Function to load the mobile CSS and hide the sidebar if the screen width is mobile-sized
        function loadMobileCSS() {
            if (window.innerWidth <= 768) {
                // Create a link element for mobile CSS
                var mobileCss = document.createElement('link');
                mobileCss.rel = 'stylesheet';
                mobileCss.href = 'css/chat-mobile.css'; // Your mobile CSS file path

                // Append it to the head
                document.head.appendChild(mobileCss);

                // Hide the sidebar for mobile screens
                var sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.style.display = 'none'; // You can also use sidebar.remove() if you want to completely remove it
                }
            }
        }
        // Run this when the page loads
        window.onload = loadMobileCSS;

        // Also check when the window is resized (optional)
        window.onresize = loadMobileCSS;
    </script>
</head>
<body>
    <div class="chat-container">
        <!-- Sidebar (You can style this later, leaving it as a placeholder) -->
        <?php include 'sidebar.php'; ?>

        <!-- Contacts Section -->
        <div class="contacts">
            <!-- Add Back button for mobile, hidden on desktop -->
             <div class="mobile-back-btn">
                <button type="button" onclick="window.history.back()">← Back</button>
            </div>
 
            <h3>Contacts</h3>
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
