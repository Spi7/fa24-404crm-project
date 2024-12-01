<?php
    include('../db_connection.php');
    connectDB();
    fetchUserData();

    $user_id = $user['USER_ID'];
    $result = $mysqli->query("SELECT MAX(EVENT_ID) as max FROM CALENDARS");
    $event_id = $result->fetch_assoc()["max"]+1;
    $event_start = $_POST["start-time"];
    $event_end = $_POST["end-time"];
    $frequency = $_POST["repeat"];
    $all_day = 0;
    if(isset($_POST["all-day"])){$all_day = 1;}
    $title = $_POST["event-title"];
    $description = $_POST["event-description"];
    $color = $_POST["color"];
    $mysqli->query("INSERT INTO CALENDARS (EVENT_ID, USER_ID, EVENT_START, FREQUENCY, TITLE, EVENT_DESCRIPTION, EVENT_END, COLOR, ALL_DAY) VALUES ('$event_id', '$user_id', '$event_start', '$frequency', '$title', '$description', '$event_end', '$color', '$all_day')");
    header('Location: calendar.php');
    exit();
?>