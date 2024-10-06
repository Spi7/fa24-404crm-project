<?php
    include('db_connection.php');
    connectDB();
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];
    $nickname = $_POST['nickname'];
    $country = $_POST['country'];
    $timezone = $_POST['timezone'];
    $gender = $_POST['gender'];
    $language = $_POST['lang'];
    //TODO: SANITIZE USER INPUT

    /* 
    unsure about parameters here
    hostname: this will be running on cattle, so just localhost?
    username & password: this will have to be someone's login credentials (ubit and person number)?
    database: the name of the database on the server? cse442_2024_fall_team_ak_db
    don't need to specify port or socket?
    */

    if($_POST["confirmPassword"]!=$_POST["password"]){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $session_token = bin2hex(random_bytes(32));
        $result = $mysqli->query("SELECT MAX(USER_ID) as max FROM ACCOUNTS");
        $user_id = $result->fetch_assoc()["max"]+1;
        $mysqli->query("INSERT INTO ACCOUNTS (USER_ID, FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, NICKNAME, COUNTRY, TIMEZONE, GENDER, LANG, SESSION_TOKEN, RESET_TOKEN, RESET_TOKEN_EXP) VALUES ('$user_id', '$firstName', '$lastName', '$email', '$password', '$nickname', '$country', '$timezone', '$gender', '$language', '$session_token' ,'',0)");
        setcookie("SESSION_TOKEN",$session_token,  time()+86400,"/");//86400    seconds in a day
        header('Location: home.php');
        exit();
    } else {
        http_response_code(400);
    }

?>