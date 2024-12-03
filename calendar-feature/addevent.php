<?php
    include('../db_connection.php');
    connectDB();
    fetchUserData();

    $user_id = $user['USER_ID'];
    $event_start = $_POST["start-time"];
    $event_end = $_POST["end-time"];
    $frequency = $_POST["repeat"];
    $all_day = 0;
    if(isset($_POST["all-day"])){$all_day = 1;}
    $title = $_POST["event-title"];
    $description = $_POST["event-description"];
    $color = $_POST["color"];
    $query = "INSERT INTO CALENDARS (USER_ID, EVENT_START, FREQUENCY, TITLE, EVENT_DESCRIPTION, EVENT_END, COLOR, ALL_DAY) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("issssssi", $user_id, $event_start, $frequency, $title, $description, $event_end, $color, $all_day);
    $stmt->execute();
    header('Location: calendar.php');
    exit();
?>