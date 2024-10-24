<?php
    // Connect to database
    include('../db_connection.php');
    connectDB();
    
    // Validate user session
    if (isset($_COOKIE['SESSION_TOKEN'])) {
        // Prepare and get user_id
        $query = "SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $_COOKIE['SESSION_TOKEN']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_id = $row["USER_ID"];
            $team_name = $_POST["confirm-team-name"];
            
            // Prepare to get TEAM_ID of the team to be deleted
            $query = "SELECT TEAM_ID FROM TEAMS WHERE TEAM_MANAGER = ? AND TEAM_NAME = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('is', $user_id, $team_name);  // Use TEAM_MANAGER instead of TEAM_OWNER
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $team_id = $row["TEAM_ID"];
                
                // Delete all rows from TEAMS_USERS for the team to be deleted
                $query = "DELETE FROM TEAMS_USERS WHERE TEAM_ID = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('i', $team_id);
                $stmt->execute();
                
                // Delete the team from TEAMS
                $query = "DELETE FROM TEAMS WHERE TEAM_ID = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('i', $team_id);
                $stmt->execute();
                
                // Redirect after deletion
                header('Location: project.php');
                exit();
            } else {
                echo "Error: Team not found.";
            }
        } else {
            echo "Error: Invalid session token.";
        }
    } else {
        echo "Error: No session token found.";
    }
?>
     