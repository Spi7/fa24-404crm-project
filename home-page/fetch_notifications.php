<?php
include_once('../db_connection.php');
include('fetch_contents.php');
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

    switch ($row['NOTIFICATION_TYPE']) {
        case 'CHATS':
            $row['message_content'] = fetchChatContent($row['LINK_ID']);
            break;
        case 'PROJECTS':
            $row['message_content'] = fetchProjectContent($row['LINK_ID']);
            break;
        case 'TEAMS':
            $row['message_content'] = fetchTeamContent($row['LINK_ID']);
            break;
        case 'CALENDARS':
            $row['message_content'] = fetchCalendarContent($row['LINK_ID']);
            break;
        case 'INVOICES':
            $row['message_content'] = fetchInvoiceContent($row['LINK_ID']);
            break;
        default:
            $row['message_content'] = null;  // In case no content is found
            break;
    }
    $notifications[] = $row;
}

// Ensure $notifications is always an array (even if empty)
if (empty($notifications)) {
    $notifications = [];  // Return an empty array if no notifications are found
}

// Return notifications as JSON
echo json_encode($notifications);
?>