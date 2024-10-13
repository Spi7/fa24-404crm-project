<?php
include '../db_connection.php';
connectDB();

// Retrive the session token
$sessionToken = $_COOKIE['SESSION_TOKEN'] ?? null;

if ($sessionToken) {
    // Validate the session token
    $query = "SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $sessionToken);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $userId = $userData['USER_ID'];

        // Fetch contacts for the logged-in user
        $contactQuery = "SELECT CONTACTS.CONTACT_NICKNAME, CONTACTS.CONTACT_EMAIL 
                         FROM CONTACTS 
                         WHERE CONTACTS.USER_ID = ?";
        $contactStmt = $mysqli->prepare($contactQuery);
        $contactStmt->bind_param("i", $userId);
        $contactStmt->execute();
        $contacts = $contactStmt->get_result();
    } else {
        echo "Invalid session token.";
        exit; // Stop further execution if the token is invalid
    }
} else {
    echo "Session token not provided.";
    exit; // Stop further execution if no token is provided
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Server</title>
    <link rel="stylesheet" href="chat.css">
    <script src="addContact.js" defer></script> <!-- Include the addContact.js file -->
    <script src="deleteContact.js" defer></script> <!-- Include the deleteContact.js file -->
    <script>
        // Function to load the mobile CSS and hide the sidebar if the screen width is mobile-sized
        function loadMobileCSS() {
            var sidebar = document.querySelector('.sidebar');
            if (window.innerWidth <= 600) {
                // Hide the sidebar for mobile screens
                if (sidebar) {
                    sidebar.style.display = 'none'; // You can also use sidebar.remove() if you want to completely remove it
                }
            }
            else {
                sidebar.style.display = 'block';
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
        <?php include '../sidebar.php'; ?>

        <!-- Contacts Section -->
        <div class="contacts">
            <div class="mobile-back-btn">
                <button type="button" onclick="window.history.back()">← Back</button>
            </div>

            <h3>Contacts</h3>
            <ul id="contact-list">
                <?php if (isset($contacts) && $contacts->num_rows > 0): ?>
                    <?php while ($contact = $contacts->fetch_assoc()): ?>
                        <li onclick="openChat('<?= htmlspecialchars($contact['CONTACT_NICKNAME']) ?>')">
                            <img src="../img/user profile icon.png" alt="other user profile" class="profile-pic" />
                            <span class="contact-nickname"><?= htmlspecialchars($contact['CONTACT_NICKNAME']) ?></span>
                            <span class="contact-email"><?= htmlspecialchars($contact['CONTACT_EMAIL']) ?></span>
                            <button class="delete-contact-btn" onclick="deleteContact('<?= htmlspecialchars($contact['CONTACT_EMAIL']) ?>')">X</button>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li id="no-contacts-message">No contacts found.</li>
                <?php endif; ?>
            </ul>
            <button class="add-contact-btn" onclick="addNewContact()">+ Add Contact</button>
        </div>

        <!-- Chat Section -->
        <div class="chat-interface">
            <div class="chat-header">
                <div class="mobile-back-btn">
                    <button type="button" onclick="goBack()">← Back</button>
                </div>
                <h3 id="chat-header-text">Select a contact to start chatting</h3>
            </div>
            <div class="chat-messages" id="chat-messages">
                <!-- Chat messages will appear here dynamically -->
            </div>
            <div class="chat-input">
                <input type="text" id="message-input" placeholder="Type a message" disabled>
                <button class="attach-btn" onclick="attachFile()">
                    <img src="../img/attachment.png" alt="Attach" class="attach-icon"> <!-- Add attachment icon -->
                </button>
                <button class="send-btn" onclick="sendMessage()" disabled>Send</button>
            </div>
        </div>
    </div>
</body>
</html>