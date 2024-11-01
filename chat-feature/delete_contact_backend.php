<?php
include '../db_connection.php';
connectDB();
fetchUserData();

$input = json_decode(file_get_contents('php://input'), true);
$emailToDelete = $input['email'] ?? null;

if ($emailToDelete) {
    // Fetch the user ID using the session token
    if (isset($user)) {
        $currentUserId = $user['USER_ID'];

        //Trying to access other chat user's userid
        $query = "SELECT USER_ID FROM ACCOUNTS WHERE EMAIL = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $emailToDelete);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $contactData = $result->fetch_assoc();
            $contactUserId = $contactData['USER_ID']; //the contact's userId

            $deleteQuery = "DELETE FROM CONTACTS WHERE CURRENT_USER_ID = ? AND CONTACT_USER_ID = ?";
            $deleteStmt = $mysqli->prepare($deleteQuery);
            $deleteStmt->bind_param("ii", $currentUserId, $contactUserId); //the current user deleted the other user
            if ($deleteStmt->execute()) {
                $reverseQuery = "DELETE FROM CONTACTS WHERE CURRENT_USER_ID = ? AND CONTACT_USER_ID = ?";
                $reverseStmt = $mysqli->prepare($reverseQuery);
                $reverseStmt->bind_param("ii", $contactUserId, $currentUserId); //the other user will also passively delete the current user
                if ($reverseStmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'The other use failed to passively delete you']);
                }
            }
            else {
                echo json_encode(['success' => false, 'message' => 'Current login user fail to delete the other user']);
            }
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Fail to find the current login user']);
        }
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Invalid session.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No email provided.']);
}
?>