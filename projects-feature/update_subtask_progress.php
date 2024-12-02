<?php
include('../db_connection.php');
header('Content-Type: application/json');
connectDB();

$input = json_decode(file_get_contents("php://input"), true);
$subtask_id = $input['subtask_id'] ?? null;
$task_id = $input['task_id'] ?? null;
$completed = $input['completed'] ?? 0;

if (!$subtask_id || !$task_id) {
    echo json_encode(['status' => 'error', 'message' => 'Subtask ID or Task ID is missing']);
    exit();
}

// Update subtask completion status
$updateSubtaskQuery = "UPDATE SUBTASKS SET COMPLETED = ? WHERE SUBTASK_ID = ?";
$updateSubtaskStmt = $mysqli->prepare($updateSubtaskQuery);
$updateSubtaskStmt->bind_param("ii", $completed, $subtask_id);
$updateSubtaskStmt->execute();
$updateSubtaskStmt->close();

// Calculate task progress based on completed subtasks
$totalSubtasks = 0;
$completedSubtasks = 0;

// Fetch total and completed subtasks for the given task
$query = "SELECT COUNT(*) as total, SUM(COMPLETED) as completed FROM SUBTASKS WHERE TASK_ID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();

$totalSubtasks = $result['total'];
$completedSubtasks = $result['completed'];

// Calculate progress percentage
$progress = ($totalSubtasks > 0) ? ($completedSubtasks / $totalSubtasks) * 100 : 0;

// Update the progress in TASKS table
$updateTaskQuery = "UPDATE TASKS SET PROGRESS = ? WHERE TASK_ID = ?";
$updateTaskStmt = $mysqli->prepare($updateTaskQuery);
$updateTaskStmt->bind_param("di", $progress, $task_id);
$updateTaskStmt->execute();
$updateTaskStmt->close();

// Return JSON response with the updated progress
echo json_encode(['status' => 'success', 'task_progress' => $progress]);
?>
