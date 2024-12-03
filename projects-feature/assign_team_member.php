<?php
include('../db_connection.php');
include('../notifications.php'); // Include notifications logic
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
        $current_user_id = $row["USER_ID"];  // User ID of the logged-in user

        // Get the project ID and team member ID from the form
        if (isset($_POST["project"]) && isset($_POST["team-member"])) {
            $project_id = $_POST["project"];        // Project selected from the form
            $team_member_id = $_POST["team-member"]; // Team member selected from the form

            // Check if the team member is already assigned to the project
            $query = "SELECT * FROM PROJECTS_USERS WHERE PROJECT_ID = ? AND USER_ID = ?";
            $stmt = $mysqli->prepare($query);
            if (!$stmt) {
                die("Error preparing SELECT query: " . $mysqli->error);
            }
            $stmt->bind_param('ii', $project_id, $team_member_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // If the user is already assigned, display an alert and redirect
                echo "<script>
                        alert('User is already assigned to this project.');
                        window.location.href = 'project.php';
                      </script>";
                exit();
            }

            // Insert the team member into the PROJECTS_USERS table
            $query = "INSERT INTO PROJECTS_USERS (PROJECT_ID, USER_ID) VALUES (?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ii', $project_id, $team_member_id);

            if ($stmt->execute()) {
                // Create a notification for the team member
                createNotification($current_user_id, $team_member_id, "PROJECTS", $project_id);

                // Success, redirect back to the project or a confirmation page
                header('Location: project.php');
                exit();
            } else {
                echo "Error: Could not assign team member to project. " . $stmt->error;
            }
        } else {
            echo "Error: Project or team member not set.";
        }
    } else {
        echo "Error: Invalid session token.";
    }
} else {
    echo "Error: No session token found.";
}
?>

