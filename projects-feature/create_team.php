<?php
// Connect to the database
include('../db_connection.php');
connectDB();

// Validate the user session
if (isset($_COOKIE['SESSION_TOKEN'])) {
    // Prepare to get the user ID based on the session token
    $query = "SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $_COOKIE['SESSION_TOKEN']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row["USER_ID"];

        // Get team name and team members from the form
        $team_name = $_POST["team-name"]; // Team name
        $team_members = $_POST["team-members"];  // Array of user IDs

        // Insert the new team into the TEAMS table
        $query = "INSERT INTO TEAMS (TEAM_MANAGER, TEAM_NAME) VALUES (?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('is', $user_id, $team_name);
        $stmt->execute();

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
        echo "Error: Invalid session token.";
    }
} else {
    echo "Error: No session token found.";
}
?>
