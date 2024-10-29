<?php
include('../db_connection.php');
connectDB();

$project_id = $_GET['project_id'] ?? null;

if (!$project_id) {
    echo json_encode(['status' => 'error', 'message' => 'Project ID is missing']);
    exit();
}

// Calculate the total progress
$query = "SELECT COUNT(*) AS total_tasks, SUM(PROGRESS) AS total_progress FROM TASKS WHERE PROJECT_ID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();

$total_tasks = $result['total_tasks'];
$total_progress = $result['total_progress'];

// Calculate average progress
$average_progress = ($total_tasks > 0) ? ($total_progress / $total_tasks) : 0;

// Update the PROJECTS table with the new total progress
$updateQuery = "UPDATE PROJECTS SET PROGRESS = ? WHERE PROJECT_ID = ?";
$updateStmt = $mysqli->prepare($updateQuery);
$updateStmt->bind_param("di", $average_progress, $project_id);
$updateStmt->execute();
$updateStmt->close();

// Return the total progress
echo json_encode(['status' => 'success', 'project_progress' => $average_progress]);
?>
