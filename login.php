<?php
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];

    $mysqli = new mysqli("localhost", "root", "", "users");
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    if(isset($_POST['email'])) {
        $query = "SELECT password FROM users.Accounts WHERE email='$email'";
        $result = $mysqli->query(query: $query);
        if($result->num_rows == 1){
            $row=$result->fetch_assoc();
            $dbPassword = $row['password'];
            if (password_verify($password, $dbPassword))    {
                $session_token = bin2hex(random_bytes(32));
                setcookie("SESSION_TOKEN",$session_token,  time()+86400,"/");//86400    seconds in a day
                header('Location: home.php');
                $updateSessionTokenQuery="UPDATE users.accounts SET SESSION_TOKEN='$session_token' WHERE email='$email'";
                $result = $mysqli->query($updateSessionTokenQuery);
            } else{
                echo "login unsucessful";
            }
        }
    }else{
        echo "login unsucessful";
    }
    // echo password_hash("testpassword", PASSWORD_DEFAULT);
?>