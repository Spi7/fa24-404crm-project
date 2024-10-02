<?php

    $email = $_POST['email'];
    $newNickname = $_POST['newNickname'];

    $mysqli = new mysqli("cattle", "jmlamann", "50307671", "cse442_2024_fall_team_ak_db");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $mysqli->query("UPDATE cse442_2024_fall_team_ak_db.ACCOUNTS SET NICKNAME='$newNickname' WHERE EMAIL='$email'");

?>