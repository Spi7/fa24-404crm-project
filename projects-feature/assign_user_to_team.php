<?php
include('../db_connection.php');
include('../notifications.php');
connectDB();

session_start();

// Validate session token
if (!isset($_COOKIE['SESSION_TOKEN'])) {
    die("Error: No session token found.");
}

// Fetch the current user ID
$query = "SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die("Error preparing session query: " . $mysqli->error);
}
$stmt->bind_param('s', $_COOKIE['SESSION_TOKEN']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Error: Invalid session token.");
}

$row = $result->fetch_assoc();
$current_user_id = $row['USER_ID']; // Logged-in user ID

// Validate POST data
if (!isset($_POST['team']) || !isset($_POST['user'])) {
    die("Error: Missing required fields (team or user).");
}

$team_id = $_POST['team']; // Team ID from form
$user_id = $_POST['user']; // User ID from form

// Check if the user is already assigned to the team
$query = "SELECT * FROM TEAMS_USERS WHERE TEAM_ID = ? AND USER_ID = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die("Error preparing SELECT query: " . $mysqli->error);
}
$stmt->bind_param('ii', $team_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>
            alert('User is already assigned to this team.');
            window.location.href = 'project.php';
          </script>";
    exit();
}

// Insert the user-team relationship into TEAMS_USERS table
$query = "INSERT INTO TEAMS_USERS (TEAM_ID, USER_ID) VALUES (?, ?)";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die("Error preparing INSERT query: " . $mysqli->error);
}
$stmt->bind_param('ii', $team_id, $user_id);

if (!$stmt->execute()) {
    die("Error executing INSERT query: " . $stmt->error);
}

// Create a notification for the assigned user
// Ensure the binding in notifications.php is corrected
createNotification($current_user_id, $user_id, "TEAMS", $team_id);

// Success, redirect back to team management page
header('Location: project.php');
exit();
?>
