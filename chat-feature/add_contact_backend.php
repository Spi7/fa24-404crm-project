<?php
include('../db_connection.php');
connectDB();

// error_reporting(E_ALL);
// ini_set('display_errors', 1); // Enable error reporting for debugging
// ob_start(); // Start output buffering

// function logMessage($message) {
//     file_put_contents('debug.log', date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
// }

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
            $userId = $userData['USER_ID'];
            $contactEmail = $_POST['email'];

            // Check if the user exists by email
            $query = "SELECT USER_ID, FIRST_NAME, LAST_NAME, NICKNAME FROM ACCOUNTS WHERE EMAIL = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("s", $contactEmail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $contactData = $result->fetch_assoc();
                $contactUserId = $contactData['USER_ID'];
                $contactFirstName = $contactData['FIRST_NAME'];
                $contactLastName = $contactData['LAST_NAME'];
                $contactNickname = $contactData['NICKNAME'];
                $result = $mysqli->query("SELECT MAX(CONTACT_ID) as max_id FROM CONTACTS");
                $contactId = $result->fetch_assoc()["max_id"] + 1;

                // Check if the user is trying to add themselves
                if ($contactUserId == $userId) {
                    echo json_encode(['status' => 'error', 'message' => 'You cannot add yourself as a contact.']);
                    exit; // Ensure to exit after echoing JSON
                }

                // Check if the contact already exists in the user's contact list
                $checkQuery = "SELECT * FROM CONTACTS WHERE USER_ID = ? AND CONTACT_EMAIL = ?";
                $checkStmt = $mysqli->prepare($checkQuery);
                $checkStmt->bind_param("is", $userId, $contactEmail);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows == 0) {
                    // Insert the contact into the CONTACTS table
                    $insertQuery = "INSERT INTO CONTACTS (CONTACT_ID, USER_ID, CONTACT_FIRSTNAME, CONTACT_LASTNAME, CONTACT_NICKNAME, CONTACT_EMAIL, CREATED_AT, UPDATED_AT) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
  
                    $insertStmt = $mysqli->prepare($insertQuery);
                    if (!$insertStmt) {
                        echo json_encode(['status' => 'error', 'message' => 'Query preparation failed: ' . $mysqli->error]);
                        exit;
                    }

                    $insertStmt->bind_param("iissss", $contactId, $userId, $contactFirstName, $contactLastName, $contactNickname, $contactEmail);

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
?>