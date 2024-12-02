<?php
include('../db_connection.php');
connectDB();

$project_id = $_POST['project_id'] ?? null;
$title = $_POST['title'] ?? null;
$description = "New Task"; // Set a default value if not provided

if (!$project_id || !$title) {
    echo json_encode(['status' => 'error', 'message' => 'Project ID or Title is missing']);
    exit();
}

// Insert new task
$query = "INSERT INTO TASKS (PROJECT_ID, TITLE, DESCRIPTION, PROGRESS) VALUES (?, ?, ?, 0)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("iss", $project_id, $title, $description);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add task']);
}
$stmt->close();
?>
