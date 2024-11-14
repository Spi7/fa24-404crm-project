<?php
include('../db_connection.php');
header('Content-Type: application/json');

// Connect to the database
connectDB();

global $mysqli;
if (!$mysqli) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

// Query to fetch clients with relevant information from both CLIENT and ACCOUNTS tables
$clientQuery = $mysqli->prepare("
    SELECT C.CLIENT_ID, A.USER_ID, A.FIRST_NAME, A.LAST_NAME, A.CLIENT_VALUES, A.GOALS, C.COMPANY_NAME, C.INDUSTRY, C.NOTES
    FROM CLIENT C
    JOIN ACCOUNTS A ON C.USER_ID = A.USER_ID
");
if (!$clientQuery) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare client query', 'error' => $mysqli->error]);
    exit();
}

$clientQuery->execute();
$clientResult = $clientQuery->get_result();

$clients = [];
while ($client = $clientResult->fetch_assoc()) {
    $clients[] = [
        'client_id' => $client['CLIENT_ID'],
        'user_id' => $client['USER_ID'],
        'name' => $client['FIRST_NAME'] . ' ' . $client['LAST_NAME'],
        'goals' => $client['GOALS'],
        'values' => $client['CLIENT_VALUES'],
        'company' => $client['COMPANY_NAME'],
        'industry' => $client['INDUSTRY'],
        'notes' => $client['NOTES']
    ];
}

$clientQuery->close();
$mysqli->close();

// Return JSON response with client data
$response = [
    'status' => 'success',
    'clients' => $clients
];

echo json_encode($response);
exit(); // Ensure no additional output after JSON response
