<?php
// Connect to the database
include('../db_connection.php');
connectDB();

// Validate user session
if (isset($_COOKIE['SESSION_TOKEN'])) {
    // Get user_id based on session token
    $query = "SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $_COOKIE['SESSION_TOKEN']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row["USER_ID"];

        // Check if form fields are set and not empty
        if (isset($_POST["team-name"]) && !empty($_POST["team-name"]) && isset($_POST["team-members"]) && !empty($_POST["team-members"])) {
            $team_name = $_POST["team-name"]; // Get team name
            $team_members = $_POST["team-members"];  // Array of user IDs (team members)

            // Insert the new team into the TEAMS table
            $query = "INSERT INTO TEAMS (TEAM_MANAGER, TEAM_NAME) VALUES (?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('is', $user_id, $team_name);
            
            if ($stmt->execute()) {
                // Get the TEAM_ID of the newly created team
                $team_id = $mysqli->insert_id;

                // Insert the team members into TEAMS_USERS
                $query = "INSERT INTO TEAMS_USERS (TEAM_ID, USER_ID) VALUES (?, ?)";
                $stmt = $mysqli->prepare($query);

                foreach ($team_members as $member_id) {
                    $stmt->bind_param('ii', $team_id, $member_id);  // Bind team_id and user_id
                    $stmt->execute();
                }

                // Redirect to project.php or another page once the team is created
                header('Location: project.php');
                exit();
            } else {
                echo "Error creating team: " . $mysqli->error;
            }
        } else {
            echo "Error: Team name or team members not set.";
        }
    } else {
        echo "Error: Invalid session token.";
    }
} else {
    echo "Error: No session token found.";
}
?>
