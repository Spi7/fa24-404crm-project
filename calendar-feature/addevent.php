<?php
    include('../db_connection.php');
    connectDB();
    if(isset($_COOKIE['SESSION_TOKEN'])) {
        $query = "SELECT USER_ID FROM ACCOUNTS WHERE session_token='$_COOKIE[SESSION_TOKEN]'";
        $result = $mysqli->query(query: $query);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $user_id = $row["USER_ID"];
            $result = $mysqli->query("SELECT MAX(EVENT_ID) as max FROM ACCOUNTS");
            $event_id = $result->fetch_assoc()["max"]+1;
            $event_start = $_POST["start-time"];
            $event_end = $_POST["end-time"];
            $frequency = $_POST["repeat"];
            $all_day = $_POST["all-day"];
            $title = $_POST["event-title"]:
            $description = $_POST["event-description"];
            $color = $_POST["color"];
            $mysqli->query("INSERT INTO CALENDARS(EVENT_ID, USER_ID, EVENT_START, FREQUENCY, TITLE, EVENT_DESCRIPTION, EVENT_END, COLOR, ALL_DAY) VALUES('$event_id', '$user_id', '$event_date', '$frequency', '$title', '$description', '$event_end', '$color', '$all_day')");
        } else {
            echo "session token not found";
        }
    }else{
        echo "no session token";
    }
?>