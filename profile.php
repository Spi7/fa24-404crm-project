<?php
    $mysqli = new mysqli("localhost", "root", "", "users");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    if(isset($_COOKIE['SESSION_TOKEN'])) {
        $query = "SELECT * FROM users.Accounts WHERE session_token='$_COOKIE[SESSION_TOKEN]'";
        $result = $mysqli->query(query: $query);
        if($result->num_rows == 1){
            $user = $result->fetch_assoc();
            array_splice($user,4,1); //remove password
            array_splice($user,9,1); //remove token
            echo json_encode($user);
        } else {
            echo "session token not found";
        }
    }else{
        echo "no session token";
    }
?>