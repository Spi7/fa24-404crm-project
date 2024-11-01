<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../db_connection.php';
connectDB();
fetchUserData(); 
if (isset($_GET["q"])) {
    if(!isset($user['USER_ID'])){
        echo json_encode(["error"=>"no userid"]);
        die();
    }
    $currentUserId = $user['USER_ID'];
    $searchQuery="%".$_GET['q']."%";
    // Check for chat history with search content
    $messageQuery = "SELECT * FROM CHAT_HISTORY WHERE (CURRENT_USER_ID = ? OR CHAT_USER_ID = ?) AND CONTENT LIKE ?";
    $stmt = $mysqli->prepare($messageQuery);
    $stmt->bind_param("iis", $currentUserId, $currentUserId,$searchQuery);
    $stmt->execute();
    $messagesResult = $stmt->get_result();

    $contactsQuery = "SELECT * FROM CONTACTS WHERE CURRENT_USER_ID = ? AND (CONTACT_NICKNAME LIKE ? or CONTACT_EMAIL LIKE ?)";
    $stmt = $mysqli->prepare($contactsQuery);
    $stmt->bind_param("iss",$currentUserId,$searchQuery,$searchQuery);
    $stmt->execute();
    $contactsResult = $stmt->get_result();


    echo json_encode([
        "messages"=>$messagesResult->fetch_all(MYSQLI_ASSOC),
        "contacts"=>$contactsResult->fetch_all(MYSQLI_ASSOC)
    ]);

}else{
    echo json_encode(["error"=>"no search query use ?q="]);
}
?>