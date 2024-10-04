<?php

    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    //user and password need to be someone's login credentials for the server?
    //safe to have that in our code?
    $mysqli = new mysqli("cattle", "jmlamann", "50307671", "cse442_2024_fall_team_ak_db");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    //confirm passwords match
    if(strcmp($newPassword, $confirmPassword) == 0){
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $mysqli->query("UPDATE ACCOUNTS SET PASSWORD='$newPassword' WHERE EMAIL='$email'");
    }
    else{
        http_response_code(400);
    }

?>