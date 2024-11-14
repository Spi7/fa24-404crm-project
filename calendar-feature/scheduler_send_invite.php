<?php
    // connect to database and fetch user data
    include('../db_connection.php');
    connectDB();
    fetchUserData();

    $user_id = $user['USER_ID'];
    $recipient_id = $_POST['RECIPIENT_ID'];
    //get max id , +1 for next valid id
    $query = "SELECT MAX(INVITE_ID) as max FROM SCHEDULER_INVITES";
    $result = $mysqli->query($query);
    $invite_id = $result->fetch_assoc()["max"]+1;
    //insert the invite into the table
    $query = "INSERT INTO SCHEDULER_INVITES (INVITE_ID, SENDER_ID, RECIPIENT_ID) VALUES ('$invite_id', '$user_id', '$recipient_id')";
    $mysqli->query($query);

?>