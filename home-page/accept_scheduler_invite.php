<?php
    // connect to database
    include('../db_connection.php');
    connectDB();

    $notification_id = $_POST['notification-id'];

    // fetch the notification
    $query = "SELECT LINK_ID, RECIPIENT_ID FROM NOTIFICATIONS WHERE NOTIFICATION_ID=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $event_id = $row["LINK_ID"];
    $recipient_id = $row["RECIPIENT_ID"];

    // fetch the event
    $query = "SELECT * FROM CALENDARS WHERE EVENT_ID=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $event_start = $row["EVENT_START"];
    $frequency = $row["FREQUENCY"];
    $title = $row["TITLE"];
    $event_description = $row["EVENT_DESCRIPTION"];
    $event_end = $row["EVENT_END"];
    $color = $row["COLOR"];
    $all_day = $row["ALL_DAY"];

    // add the event to the recipient's calendar
    $query = "INSERT INTO CALENDARS (USER_ID, EVENT_START, FREQUENCY, TITLE, EVENT_DESCRIPTION, EVENT_END, COLOR, ALL_DAY) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("issssssi", $recipient_id, $event_start, $frequency, $title, $event_description, $event_end, $color, $all_day);
    $stmt->execute();

    // delete the notification
    $query = "DELETE FROM NOTIFICATIONS WHERE NOTIFICATION_ID=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();

    header('Location: home.php');
    exit();
?>