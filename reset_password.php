<?php

    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    //user and password need to be someone's login credentials for the server?
    //safe to have that in our code?
    $mysqli = new mysqli("localhost", "", "", "cse442_2024_fall_team_ak_db");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    //confirm passwords match
    if(strcmp($new_password, $confirm_password) == 0){
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $mysqli->query("UPDATE cse442_2024_fall_team_ak_db.ACCOUNTS SET PASSWORD='$new_password' WHERE EMAIL='$email'");
    }
    else{
        http_response_code(400);
    }

?>