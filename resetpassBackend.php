<?php
include('db_connection.php');
connectDB();

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
if (isset($_POST["email"])) {
    $email = strtolower(string: $_POST["email"]);
    // //if body contains email we are at stage 1 of reset
    
    $reset_token = bin2hex(string: random_bytes(length: 32));
    $result = $mysqli->query("SELECT user_id FROM accounts WHERE email='$email'");
    if ($result->num_rows > 0) {
        $mysqli->query("UPDATE accounts SET reset_token='$reset_token' WHERE email='$email'");
        $expTime = time() + 900; //give user 15 minutes to update password
        $mysqli->query(query: "UPDATE accounts SET RESET_TOKEN_EXP='$expTime' WHERE email='$email'");
        echo "STEP2";
        $message="your reset token is: ".$reset_token." and will expire in 15 minutes";
        mail($_POST["email"],"404 crm reset token", $message);
    } else {
        echo "email not found";
    }
    
} else if (isset($_POST["token"]) && isset($_POST["password"]) && $_POST["password"] == $_POST["confirmPassword"]) {
    $reset_token = $_POST["token"];
    $query = "SELECT reset_token_exp FROM accounts WHERE reset_token='$reset_token'";
    $result = $mysqli->query($query);
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($user["reset_token_exp"] > time()) {
            $newPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $mysqli->query("UPDATE accounts SET password='$newPassword' WHERE reset_token='$reset_token'");
            $mysqli->query(query: "UPDATE accounts SET reset_token_exp=0 WHERE reset_token='$reset_token'");
            echo "DONE";
        } else {
            echo "Expired token";
            http_response_code(response_code: 400);
        }
    }
} else {
    echo $_POST["token"];
    echo $_POST["password"];
    echo $_POST["confirmPassword"];

    echo "invalid params";
    http_response_code(400);
}

//TODO: SANITIZE USER INPUT

/* 
unsure about parameters here
hostname: this will be running on cattle, so just localhost?
username & password: this will have to be someone's login credentials (ubit and person number)?
database: the name of the database on the server? cse442_2024_fall_team_ak_db
don't need to specify port or socket?
*/

// Check connection

