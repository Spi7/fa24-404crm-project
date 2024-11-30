<?php
include_once('../db_connection.php');

function fetchChatContent($link_id) {
    global $mysqli;

    $query = "SELECT CONTENT FROM CHAT_HISTORY WHERE CHAT_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $link_id);
    $stmt->execute();
    $stmt->bind_result($content);
    $stmt->fetch();

    return $content;
}

function fetchCalendarContent($link_id) {
    global $mysqli;

    $query = "SELECT TITLE FROM CALENDARS WHERE EVENT_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $link_id);
    $stmt->execute();
    $stmt->bind_result($eventName);
    $stmt->fetch();

    return $eventName;
}

function fetchInvoiceContent($link_id) {
    global $mysqli;

    $query = "SELECT `DESCRIPTION` FROM INVOICES WHERE INVOICE_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $link_id);
    $stmt->execute();
    $stmt->bind_result($invoiceDetails);
    $stmt->fetch();

    return $invoiceDetails;
}

function fetchProjectContent($link_id) {
    global $mysqli;

    $query = "SELECT `TITLE` FROM PROJECTS WHERE PROJECT_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $link_id);
    $stmt->execute();
    $stmt->bind_result($projectName);
    $stmt->fetch();

    return $projectName;
}


function fetchTeamContent($link_id) {
    global $mysqli;
    
    $query = "SELECT TEAM_NAME FROM TEAMS WHERE TEAM_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $link_id); 
    $stmt->execute();
    $stmt->bind_result($teamName);
    $stmt->fetch();
    
    return $teamName;
}

?>


