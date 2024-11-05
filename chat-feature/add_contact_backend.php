<?php
include_once('../db_connection.php');
connectDB();

// Fetch user data based on session token
fetchUserData(); // This will set the $user variable

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($user)) { // Check if user data is set
        $currentUserId = $user['USER_ID']; // Current user's ID
        $currentUserNickname = $user['NICKNAME']; // Current user's nickname
        $currentUserEmail = $user['EMAIL']; // Current user's email
        $contactEmail = $_POST['email'];

        // Check if the other user exists by email
        $query = "SELECT USER_ID, NICKNAME FROM ACCOUNTS WHERE EMAIL = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $contactEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $contactData = $result->fetch_assoc();
            $contactUserId = $contactData['USER_ID']; // User being added
            $contactNickname = $contactData['NICKNAME'];

            // Check if the user is trying to add themselves
            if ($contactUserId == $currentUserId) {
                echo json_encode(['status' => 'error', 'message' => 'You cannot add yourself as a contact.']);
                exit;
            }

            // Check if the contact already exists in the user's contact list
            $checkQuery = "SELECT * FROM CONTACTS WHERE CURRENT_USER_ID = ? AND CONTACT_USER_ID = ?";
            $checkStmt = $mysqli->prepare($checkQuery);
            $checkStmt->bind_param("ii", $currentUserId, $contactUserId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows == 0) {
                // Insert the contact into the CONTACTS table
                $insertQuery = "INSERT INTO CONTACTS (CURRENT_USER_ID, CONTACT_USER_ID, CONTACT_NICKNAME, CONTACT_EMAIL, CREATED_AT, UPDATED_AT) VALUES (?, ?, ?, ?, NOW(), NOW())";
                $insertStmt = $mysqli->prepare($insertQuery);

                if (!$insertStmt) {
                    echo json_encode(['status' => 'error', 'message' => 'Query preparation failed: ' . $mysqli->error]);
                    exit;
                }

                $insertStmt->bind_param("iiss", $currentUserId, $contactUserId, $contactNickname, $contactEmail);

                // This line $insertStmt adds the contacts in
                if ($insertStmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Contact added successfully.', 'nickname' => $contactNickname,'id'=>$contactUserId]);
                    $reverseInsertQuery = "INSERT INTO CONTACTS (CURRENT_USER_ID, CONTACT_USER_ID, CONTACT_NICKNAME, CONTACT_EMAIL, CREATED_AT, UPDATED_AT) VALUES (?, ?, ?, ?, NOW(), NOW())";
                    $reverseInsertStmt = $mysqli->prepare($reverseInsertQuery);
                    $reverseInsertStmt->bind_param("iiss", $contactUserId, $currentUserId, $currentUserNickname, $currentUserEmail);
                    $reverseInsertStmt->execute();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to insert contact: ' . $insertStmt->error]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Contact already exists in your contact list.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'The email provided does not correspond to any user.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid session.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}