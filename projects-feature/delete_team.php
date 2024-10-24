<?php
    # connect to database
    include('../db_connection.php');
    connectDB();
    # validate user session
    if(isset($_COOKIE['SESSION_TOKEN'])) {
        # get user_id
        $query = "SELECT USER_ID FROM ACCOUNTS WHERE session_token='$_COOKIE[SESSION_TOKEN]'";
        $result = $mysqli->query(query: $query);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $user_id = $row["USER_ID"];
            $team_name = $_POST["TEAM_NAME"];
            # get the TEAM_ID for the team to be deleted
            $query = "SELECT TEAM_ID FROM TEAMS WHERE TEAM_MANAGER='$user_id' AND TEAM_NAME='$team_name'";
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();
            $team_id = $row["TEAM_ID"];
            # delete all rows from TEAMS_USERS for the team to be deleted
            $query = "DELETE FROM TEAMS_USERS WHERE TEAM_ID='$team_id'";
            $mysqli->query($query);
            # delete the team from TEAMS
            $query = "DELETE FROM TEAMS WHERE TEAM_ID='$team_id'";
            $mysqli->query($query);
            header('Location: project.php');
            exit();
        } else {
            echo "session token not found";
        }
    }else{
        echo "no session token";
    }
            