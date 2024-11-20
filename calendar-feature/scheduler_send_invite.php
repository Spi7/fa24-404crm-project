<?php
    // connect to database and fetch user data
    include('../db_connection.php');
    include('../notifications.php');
    connectDB();
    fetchUserData();

    $user_id = $user['USER_ID'];
    $recipient_id = $_POST['select-contact'];
    $event_id = $_POST['select-event'];
    //get max id , +1 for next valid id
    $query = "SELECT MAX(INVITE_ID) as max FROM SCHEDULER_INVITES";
    $result = $mysqli->query($query);
    $invite_id = $result->fetch_assoc()["max"]+1;
    //insert the invite into the table
    $query = "INSERT INTO SCHEDULER_INVITES (INVITE_ID, EVENT_ID, SENDER_ID, RECIPIENT_ID) VALUES ('$invite_id', '$event_id', '$user_id', '$recipient_id')";
    $mysqli->query($query);

    // this makes the SCHEDULER_INVITES table redundant? instead of linking to SCHEDULER_INVITES, link directly to the CALENDARS event?
    createNotification($user_id, $recipient_id, "SCHEDULER_INVITES", $invite_id);

    //redirect to calendar and exit
    header('Location: calendar.php');
    exit();

?>