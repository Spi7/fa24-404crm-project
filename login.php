<?php
    include('db_connection.php');
    connectDB();
    
    $errorString = "login unsucessful <a href='login.html'>back to login</a>";
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];
    if(isset($_POST['email'])) {
        $query = "SELECT password FROM ACCOUNTS WHERE email='$email'";
        $result = $mysqli->query(query: $query);
        if($result->num_rows == 1){
            $row=$result->fetch_assoc();
            $dbPassword = $row['password'];
            if (password_verify($password, $dbPassword))    {
                $session_token = bin2hex(random_bytes(32));
                setcookie("SESSION_TOKEN",$session_token,  time()+86400,"/");//86400    seconds in a day
                $mysqli->query("UPDATE ACCOUNTS SET SESSION_TOKEN='$session_token' WHERE email='$email'");
                header(header: 'Location: home-page/home.php');
            } else{
                echo $errorString;
                exit();
            }
        }
    }else{
        echo $errorString;
    }
?>