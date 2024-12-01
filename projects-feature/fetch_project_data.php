<?php
include('../db_connection.php');
header('Content-Type: application/json');

connectDB();

$project_id = $_GET['project_id'] ?? null;

// Validate that project_id is provided
if (!$project_id) {
    echo json_encode(['status' => 'error', 'message' => 'Project ID is missing']);
    exit();
}

// Fetch project data
$projectQuery = $mysqli->prepare("SELECT PROJECT_ID, TITLE, PROGRESS FROM PROJECTS WHERE PROJECT_ID = ?");
if (!$projectQuery) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare project query', 'error' => $mysqli->error]);
    exit();
}
$projectQuery->bind_param("i", $project_id);
$projectQuery->execute();
$projectResult = $projectQuery->get_result();
$project = $projectResult->fetch_assoc();
$projectQuery->close();

// Check if project exists
if (!$project) {
    echo json_encode(['status' => 'error', 'message' => 'Project not found']);
    exit();
}

// Fetch tasks for the project
$tasks = [];
$taskQuery = $mysqli->prepare("SELECT TASK_ID, TITLE, DESCRIPTION, PROGRESS FROM TASKS WHERE PROJECT_ID = ?");
if (!$taskQuery) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare task query', 'error' => $mysqli->error]);
    exit();
}
$taskQuery->bind_param("i", $project_id);
$taskQuery->execute();
$taskResult = $taskQuery->get_result();

while ($task = $taskResult->fetch_assoc()) {
    $task_id = $task['TASK_ID'];

    // Fetch subtasks for each task
    $subtasks = [];
    $subtaskQuery = $mysqli->prepare("SELECT SUBTASK_ID, DESCRIPTION, COMPLETED FROM SUBTASKS WHERE TASK_ID = ?");
    if (!$subtaskQuery) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare subtask query', 'error' => $mysqli->error]);
        exit();
    }
    $subtaskQuery->bind_param("i", $task_id);
    $subtaskQuery->execute();
    $subtaskResult = $subtaskQuery->get_result();

    while ($subtask = $subtaskResult->fetch_assoc()) {
        $subtasks[] = $subtask;
    }
    $subtaskQuery->close();

    // Add subtasks to the task
    $task['subtasks'] = $subtasks;
    $tasks[] = $task;
}
$taskQuery->close();

// Combine project, tasks, and subtasks into a response
$response = [
    'status' => 'success',
    'project' => $project,
    'tasks' => $tasks
];

// Return JSON response
echo json_encode($response);
?>
