<?php
    // connect to database and fetch user data
    include('../db_connection.php');
    include('../notifications.php');
    connectDB();
    fetchUserData();

    $user_id = $user['USER_ID'];
    $recipient_id = $_POST['select-contact'];
    $event_id = $_POST['select-event'];

    // this makes the SCHEDULER_INVITES table redundant? instead of linking to SCHEDULER_INVITES, link directly to the CALENDARS event?
    createNotification($user_id, $recipient_id, "CALENDARS", $event_id);

    //redirect to calendar and exit
    header('Location: calendar.php');
    exit();

?>