<?php
include '../db_connection.php';
connectDB();
fetchUserData();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentUserId = $user['USER_ID'];
    $chatUserId = $_POST['chat_user_id'];

    // Check for existing chat history
    $query = "SELECT CONTENT, FILE_PATH, CHAT_USER_ID FROM CHAT_HISTORY
              WHERE (CURRENT_USER_ID = ? AND CHAT_USER_ID = ?)
              OR (CURRENT_USER_ID = ? AND CHAT_USER_ID = ?)";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iiii", $currentUserId, $chatUserId, $chatUserId, $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch and return chat history
        $messages = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($messages);
    } else {
        // Return an empty array indicating no chat history
        echo json_encode([]);
    }
}
?>