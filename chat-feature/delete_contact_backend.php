<?php
include '../db_connection.php'; // Include your database connection
connectDB();

$input = json_decode(file_get_contents('php://input'), true);
$emailToDelete = $input['email'] ?? null;

if ($emailToDelete) {
    // Fetch the user ID using the session token
    $sessionToken = $_COOKIE['SESSION_TOKEN'] ?? null;
    $userIdQuery = "SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
    $stmt = $mysqli->prepare($userIdQuery);
    $stmt->bind_param("s", $sessionToken);
    $stmt->execute();
    $userResult = $stmt->get_result();
    
    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $userId = $userData['USER_ID'];

        // Prepare the delete statement
        $query = "DELETE FROM CONTACTS WHERE CONTACT_EMAIL = ? AND USER_ID = ?";
        $deleteStmt = $mysqli->prepare($query);
        $deleteStmt->bind_param("si", $emailToDelete, $userId);
        if ($deleteStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete contact.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid session.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No email provided.']);
}
?>