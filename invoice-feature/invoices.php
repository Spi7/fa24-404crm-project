<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

include "../db_connection.php";
connectDB();
$userIDQuery = $mysqli->query("SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN='$_COOKIE[SESSION_TOKEN]'");
if ($userIDQuery->num_rows == 0) {
    die("error session token not found");
}
$userID = $userIDQuery->fetch_assoc()["USER_ID"];
//get dest id - already checked there is a row before
if(!isset($_GET["clientId"])){
    $invoices = $mysqli->query("SELECT * FROM INVOICES WHERE SENDER='$userID' or RECIPIENT='$userID'");
} else {
    // convert to int to prevent sql injection - userID is also trusted bc it comes from our db and code and is not a user input
    // a wacky - possibly attack - string will just turn into a 0
    $filterID=(int)$_GET["clientId"];
    $invoices = $mysqli->query("SELECT * FROM INVOICES WHERE (SENDER='$userID' AND RECIPIENT='$filterID') or (RECIPIENT='$userID' and SENDER='$userID')");
}
$invoicesInfo = [];
$invoiceIDs = [];
while ($invoice = $invoices->fetch_assoc()) {
    array_push($invoicesInfo,$invoice);
    array_push($invoiceIDs, $invoice["INVOICE_ID"]);
}
$noInvoices = $invoices->num_rows == 0;
if (!$noInvoices) {
    $invoiceItems = $mysqli->query("SELECT * FROM INVOICE_ITEMS WHERE INVOICE_ID IN (" . implode(',', $invoiceIDs) . ")");
}

// $mysqli->query(query: "INSERT INTO INVOICES VALUES ('$invoiceID','$senderID','$destUserId',now(),'$_POST[invoiceDueDate]','$_POST[invoiceBA]','$_POST[invoiceName]')");
// for ($i = 0; $i < count(value: $quantities); $i++) {
//     $invoiceItemID = (int) $mysqli->query("SELECT MAX(ITEM_ID) as max FROM INVOICE_ITEMS")->fetch_assoc()["max"] + 1;
//     $mysqli->query("INSERT INTO INVOICE_ITEMS VALUES ('$invoiceItemID','$invoiceID','$quantities[$i]','$prices[$i]','$descriptions[$i]')");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoices</title>
    <link rel="stylesheet" href="invoices.css"> <!-- Link to external CSS file -->
</head>

<body>
    <a href="../home-page/home.php" class="button" id="homeButtonWrapper">
        <img id="homeButton" src="../img/home.png" alt="Home">
    </a>
    <div id="main-container">
        <h1>Invoices Involving You</h1>
        <table class="invoice-table">
            <tr>
                <th>Invoice ID</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Created</th>
                <th>Due</th>
                <th>Description</th>
                <th>Address</th>
            </tr>
            <?php
            foreach ($invoicesInfo as $row){
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <h1>Invoice Items Involving Your Invoices</h1>
        <table class="invoice-table">
            <tr>
                <th>Item ID</th>
                <th>Invoice ID</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
            <?php
            if ($noInvoices == false) {
                while ($row = $invoiceItems->fetch_row()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
</body>

</html>