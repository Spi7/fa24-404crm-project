<?php
include '../db_connection.php';
connectDB();
fetchUserData();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($user)) {
        $currentUserId = $user['USER_ID'];
        $chatUserId = $_POST['other_user_id'];
        $content = $_POST['content'];
        $filePath = null;
        $isImage = false;

        // Check if a file has been uploaded
        if (isset($_FILES['file'])) {
            if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                // Set the target directory for uploads
                $targetDir = 'uploads/'; //current issue, must modify this to 777 (but is not good)
                $fileName = basename($_FILES['file']['name']);
                $targetFilePath = $targetDir . uniqid() . '_' . $fileName; // Prevent filename conflicts

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                    $filePath = $targetFilePath; // Store the file path
                    
                    // Check if the uploaded file is an image
                    $fileType = mime_content_type($targetFilePath);
                    $isImage = strpos($fileType, 'image/') === 0; // Check if it's an image
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to move uploaded file."]);
                    exit;
                }
            } 
        }

        // Prepare the SQL statement and insert the message into the database
        $stmt = $mysqli->prepare("INSERT INTO CHAT_HISTORY (CURRENT_USER_ID, CHAT_USER_ID, CONTENT, FILE_PATH) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            echo json_encode(["status" => "error", "message" => "Failed to prepare the SQL statement: " . $mysqli->error]);
            exit;
        }

        $stmt->bind_param("iiss", $currentUserId, $chatUserId, $content, $filePath);

        if ($stmt->execute()) {
            // Return response including the file path and image status
            echo json_encode([
                "status" => "success", 
                "message" => "Message sent!", 
                "file_path" => $filePath, 
                "is_image" => $isImage // Include whether the uploaded file is an image
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to insert message: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "User not authenticated."]);
    }

    $mysqli->close(); // Close the database connection
}
?>