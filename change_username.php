<?php

    $email = $_POST['email'];
    $new_nickname = $_POST['new_nickname'];

    $mysqli = new mysqli("localhost", "", "", "cse442_2024_fall_team_ak_db");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $mysqli->query("UPDATE cse442_2024_fall_team_ak_db.ACCOUNTS SET NICKNAME='$new_nickname' WHERE EMAIL='$email'");

?>