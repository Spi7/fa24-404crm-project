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
$clientQuery = $mysqli->prepare("SELECT * FROM CLIENT;");
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
        'affiliation' => $client['AFFILIATION'],
        'company_name' => $client['COMPANY_NAME'],
        'goals' => $client['GOALS'],
        'values' => $client['COMPANY_VALUES'],
        'invoice_history' => $client['INVOICE_HISTORY'],
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
