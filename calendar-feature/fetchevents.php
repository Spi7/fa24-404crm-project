<?php
    include('../db_connection.php');
    connectDB();
    if(isset($_COOKIE['SESSION_TOKEN'])) {
        $query = "SELECT USER_ID FROM ACCOUNTS WHERE session_token='$_COOKIE[SESSION_TOKEN]'";
        $result = $mysqli->query($query);
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_id = $row["USER_ID"];
            $events_query = "SELECT * FROM CALENDARS WHERE USER_ID = '$user_id'";
            $events_result = $mysqli->query($events_query);
            $events = [];
            while($event = $events_result->fetch_assoc()) {
                $events[] = $event;
            }
            header('Content-Type: application/json');
            echo json_encode($events);

        } else {
            echo json_encode(["error" => "Session token not found."]);
        }
    } else {
        echo json_encode(["error" => "No session token."]);
    }
    $mysqli->close();
?>
