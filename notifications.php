<?php

    function createNotification($sender_id, $recipient_id, $table, $link_id){
        global $mysqli;
        $query = "INSERT INTO NOTIFICATIONS (SENDER_ID, RECIPIENT_ID, NOTIFICATION_TYPE, LINK_ID) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("iisi", $sender_id, $recipient_id, $table, $link_id);
        $stmt->execute();
    }

?>