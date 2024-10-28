<?php
include('../db_connection.php');
connectDB();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sessionToken = $_COOKIE['SESSION_TOKEN'] ?? null;

    if ($sessionToken) {
        // Validate session token
        $query = "SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $sessionToken);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            $currentUserId = $userData['USER_ID']; // Current user's ID
            $contactEmail = $_POST['email'];

            // Check if the user exists by email
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

                    if ($insertStmt->execute()) {
                        echo json_encode(['status' => 'success', 'message' => 'Contact added successfully.', 'nickname' => $contactNickname]);
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
            echo json_encode(['status' => 'error', 'message' => 'Invalid session token.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Session token not provided.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}