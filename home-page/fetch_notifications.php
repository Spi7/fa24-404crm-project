<?php
include_once('../db_connection.php');
connectDB();
fetchUserData();

$userId = $user["USER_ID"];  // Get the logged-in user's ID

// Query to fetch notifications along with the sender's email from the ACCOUNTS table
$query = "
    SELECT n.*, a.EMAIL AS sender_email 
    FROM NOTIFICATIONS n
    JOIN ACCOUNTS a ON n.SENDER_ID = a.USER_ID 
    WHERE n.RECIPIENT_ID = ? 
    ORDER BY n.CREATED_AT DESC
";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch notifications
$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Ensure $notifications is always an array (even if empty)
if (empty($notifications)) {
    $notifications = [];  // Return an empty array if no notifications are found
}

// Return notifications as JSON
echo json_encode($notifications);
?>
