<?php

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = strtolower($_POST['email']);
    $password = $_POST['password']; 
    $nickname = $_POST['nickname'];
    $country = $_POST['country'];
    $timezone = $_POST['timezone'];
    $gender = $_POST['gender'];
    $language = $_POST['language'];

    //TODO: SANITIZE USER INPUT

    /* 
    unsure about parameters here
    hostname: this will be running on cattle, so just localhost?
    username & password: this will have to be someone's login credentials (ubit and person number)?
    database: the name of the database on the server? cse442_2024_fall_team_ak_db
    don't need to specify port or socket?
    */
    $mysqli = new mysqli("localhost", "", "", "cse442_2024_fall_team_ak_db");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    if($_POST["confirmPassword"]!=$_POST["password"]){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $result = mysqli->query("SELECT MAX(USER_ID) FROM cse442_2024_fall_team_ak_db.ACCOUNTS");
        $user_id = $result ++;
        $mysqli->query("INSERT INTO cse442_2024_fall_team_ak_db.ACCOUNTS(USER_ID, FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, NICKNAME, COUNTRY, TIMEZONE, GENDER, LANG VALUES('$user_id', '$first_name', '$last_name', '$email', '$password', '$nickname', '$country', '$timezone', '$gender', '$language')");    
    } else {
        http_response_code(400);
    }

?>