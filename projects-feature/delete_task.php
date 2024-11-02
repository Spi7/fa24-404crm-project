<?php
include('../db_connection.php');
connectDB();

$task_id = $_POST['task_id'] ?? null;

if (!$task_id) {
    echo json_encode(['status' => 'error', 'message' => 'Task ID is missing']);
    exit();
}

// Delete the task
$query = "DELETE FROM TASKS WHERE TASK_ID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $task_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete task']);
}
$stmt->close();
?>
