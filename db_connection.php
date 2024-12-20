<?php
function connectDB() {
	global $mysqli;
    $mysqli = mysqli_connect("DB_HOST", "DB_USER", "DB_PASSWORD", "DB_NAME");

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	} 
}

// Function to fetch user data based on session token
function fetchUserData() {
    global $mysqli, $user;
    $session_token = $_COOKIE['SESSION_TOKEN'] ?? null;
    // Check if SESSION_TOKEN cookie is set
    if (isset($_COOKIE['SESSION_TOKEN'])) {
        
        $session_token = $_COOKIE['SESSION_TOKEN'];

        // Use a prepared statement to prevent SQL injection
        $query = "SELECT * FROM ACCOUNTS WHERE SESSION_TOKEN = ?";
        $stmt = $mysqli->prepare($query);

        // Check if statement preparation was successful
        if (!$stmt) {
            echo "Database error: " . $mysqli->error;
            exit();
        }

        // Bind the session token parameter
        $stmt->bind_param("s", $session_token);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a valid user is found
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc(); // Fetch user data
        } else {
            echo "Invalid session. <a href='../login.html'>Back to login</a>";
            exit();
        }
    } else {
        echo "You are not logged in. <a href='../login.html'>Back to login</a>";
        exit();
    }
}
?>