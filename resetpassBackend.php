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
    $result = $mysqli->query("SELECT USER_ID FROM ACCOUNTS WHERE EMAIL='$email'");
    if ($result->num_rows > 0) {
        $mysqli->query("UPDATE ACCOUNTS SET RESET_TOKEN='$reset_token' WHERE EMAIL='$email'");
        $expTime = time() + 900; //give user 15 minutes to update password
        $mysqli->query(query: "UPDATE ACCOUNTS SET RESET_TOKEN_EXP='$expTime' WHERE EMAIL='$email'");
        echo "STEP2";
        $message="your reset token is: ".$reset_token." and will expire in 15 minutes";
        mail($_POST["email"],"404 crm reset token", $message);
    } else {
        echo "email not found";
    }
    
} else if (isset($_POST["token"]) && isset($_POST["password"]) && $_POST["password"] == $_POST["confirmPassword"]) {
    $reset_token = $_POST["token"];
    $query = "SELECT reset_token_exp FROM ACCOUNTS WHERE RESET_TOKEN='$reset_token'";
    $result = $mysqli->query($query);
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($user["reset_token_exp"] > time()) {
            $newPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $mysqli->query("UPDATE ACCOUNTS SET PASSWORD='$newPassword' WHERE RESET_TOKEN='$reset_token'");
            $mysqli->query(query: "UPDATE ACCOUNTS SET RESET_TOKEN_EXP=0 WHERE RESET_TOKEN='$reset_token'");
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