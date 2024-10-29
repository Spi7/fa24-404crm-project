<?php
include '../db_connection.php';
connectDB(); 
fetchUserData(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($user)) { // Ensure user data is available
        $currentUserId = $user['USER_ID']; // Get current user's ID
        $currChatUserId = $_POST['other_user_id'];
        $content = $_POST['content'];

        // Prepare and bind
        $stmt = $mysqli->prepare("INSERT INTO CHAT_HISTORY (CURRENT_USER_ID, CHAT_USER_ID, CONTENT) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $currentUserId, $currChatUserId, $content);

        if ($stmt->execute()) {
            header(header: 'Content-type: application/json');
            echo json_encode(["status" => "success", "message" => "Message sent!"]);
        } else {
            header('Content-type: application/json');
            echo json_encode(["status" => "error", "message" => "Message not sent!"]);
        }
        $stmt->close();
    
    } else {
        header('Content-type: application/json');
        echo json_encode(["status" => "error", "message" => "User not authenticated."]);
    }
    $mysqli->close(); // Close the database connection
}
?>