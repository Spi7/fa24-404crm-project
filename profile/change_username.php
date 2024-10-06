<?php
    include('../db_connection.php');
    connectDB();
    $newNickname = $_POST['newNickname'];
    $mysqli->query("UPDATE ACCOUNTS SET NICKNAME='$newNickname' WHERE SESSION_TOKEN='$_COOKIE[SESSION_TOKEN]'");
    header(header: 'Location: userinfo.php');