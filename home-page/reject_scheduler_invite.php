<?php
    // connect to database
    include('../db_connection.php');
    connectDB();

    $notification_id = $_POST['notification-id'];

    // delete the notification
    $query = "DELETE FROM NOTIFICATIONS WHERE NOTIFICATION_ID=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();

    header('Location: home.php');
    exit();
?>