<?php
    include('../db_connection.php');
    connectDB();
    fetchUserData();
    if(isset($_COOKIE['SESSION_TOKEN'])) {
        $query = "SELECT * FROM ACCOUNTS WHERE SESSION_TOKEN='$_COOKIE[SESSION_TOKEN]'";
        $result = $mysqli->query(query: $query);
        if($result->num_rows == 1){
            $user = $result->fetch_assoc();
            array_splice($user,4,1); //remove password
            array_splice($user,9,3); //remove tokens
        } else {
            echo "session token not found";
        }
    }else{
        echo "no session token";
    }
?>