<?php

    function createNotification($sender_id, $recipient_id, $table, $link_id){
        global $mysqli;
        $query = "INSERT INTO NOTIFICATIONS (SENDER_ID, RECIPIENT_ID, NOTIFICATION_TYPE, LINK_ID) VALUES ('$sender_id', '$recipient_id', '$table', '$link_id')";
        $mysqli->query($query);
    }

?>