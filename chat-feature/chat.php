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
        $contactQuery = "SELECT CONTACTS.CONTACT_NICKNAME, CONTACTS.CONTACT_EMAIL, CONTACTS.CONTACT_USER_ID 
                         FROM CONTACTS 
                         WHERE CONTACTS.CURRENT_USER_ID = ?";
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
    <link rel="stylesheet" href="chat-css/contact.css">
    <link rel="stylesheet" href="chat-css/message.css">
    <script src="chat-js/addContact.js" defer></script> <!-- Include the addContact.js file -->
    <script src="chat-js/deleteContact.js" defer></script> <!-- Include the deleteContact.js file -->
    <script src="chat-js/searchContact.js" defer></script> <!-- Include the search js file -->
    <script src="chat-js/message.js" defer></script> <!-- Include the search js file -->
    <script>
        var openChatEmail=""
        // Function to load the mobile CSS and hide the sidebar if the screen width is mobile-sized
        function loadMobileCSS(load) {
        var sidebar = document.querySelector('.sidebar');
        var chatInterface = document.querySelector('.chat-interface');
        var cList = document.querySelector('.contacts');
        
        if (window.innerWidth <= 800) {
            // Hide the sidebar and chat interface for mobile screens
            if (sidebar) {
                sidebar.style.display = 'none';
            }
            if(chatInterface.style.display!='none' && cList.style.display!='none'){
                chatInterface.style.display = 'none';

            }
        } else {
            // Show the sidebar and chat interface for larger screens
            if (sidebar) {
                sidebar.style.display = 'block';
            }
            if (chatInterface) {
                chatInterface.style.display = 'flex';
            }
            if (cList) {
                cList.style.display = 'flex';
            }
        }
    }

    // Run this when the page loads
    window.addEventListener('load', loadMobileCSS);
    window.addEventListener('resize', loadMobileCSS);
    </script>
</head>
<body>
    <div class="chat-container">
        <!-- Sidebar (You can style this later, leaving it as a placeholder) -->
        <?php include '../sidebar.php'; ?>

        <!-- Contacts Section -->
        <?php include 'contact.php'; ?>

        <!-- Chat Section -->
        <?php include 'chat_interface.php'; ?>

    </div>
</body>
</html>