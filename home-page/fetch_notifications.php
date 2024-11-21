<?php
include_once('../db_connection.php');
connectDB();
fetchUserData();

$userId = $user["USER_ID"]; 

// Query to fetch notifications
$query = "SELECT * FROM NOTIFICATIONS WHERE RECIPIENT_ID = ? ORDER BY CREATED_AT DESC";
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
    $notifications = []; // Return an empty array if no notifications are found
}

// Return notifications as JSON
echo json_encode($notifications);
?>
