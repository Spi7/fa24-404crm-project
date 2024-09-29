<?php

    $email = $_POST['email'];
    $new_password = hash('sha256', $_POST['new_password']);

    //user and password need to be someone's login credentials for the server?
    //safe to have that in our code?
    $mysqli = new mysqli("localhost", "", "", "cse442_2024_fall_team_ak_db");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $mysqli->query("UPDATE ACCOUNTS SET PASSWORD='$new_password' WHERE EMAIL='$email'");

?>