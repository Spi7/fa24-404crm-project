<?php

    function createNotification($sender_id, $recipient_id, $table, $link_id){
        global $mysqli;
        //check if duplicate notification
        $query = "SELECT NOTIFICATION_ID FROM NOTIFICATIONS WHERE SENDER_ID=? AND RECIPIENT_ID=? AND NOTIFICATION_TYPE=? AND LINK_ID=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("iisi", $sender_id, $recipient_id, $table, $link_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows != 0){
            return;
        }


        //insert notification into notifications table
        $query = "INSERT INTO NOTIFICATIONS (SENDER_ID, RECIPIENT_ID, NOTIFICATION_TYPE, LINK_ID) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("iisi", $sender_id, $recipient_id, $table, $link_id);
        $stmt->execute();
    }

?>