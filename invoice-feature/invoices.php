<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

include "../db_connection.php";
connectDB();
$stmt = $mysqli->prepare("SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN=?");
$stmt->bind_param("s",$_COOKIE["SESSION_TOKEN"]);
$stmt->execute();
$userIDQuery=$stmt->get_result();
if ($userIDQuery->num_rows == 0) {
    die("error session token not found");
}
$userID = $userIDQuery->fetch_column(0);
//get dest id - already checked there is a row before
if(!isset($_GET["clientId"])){
    $stmt = $mysqli->prepare("SELECT * FROM INVOICES WHERE SENDER=? or RECIPIENT=?");
    $stmt->bind_param("ss",$userID,$userID);
    $stmt->execute();
    $invoices=$stmt->get_result();
} else {
    // convert to int to prevent sql injection - userID is also trusted bc it comes from our db and code and is not a user input
    // a wacky - possibly attack - string will just turn into a 0
    $filterID=(int)$_GET["clientId"];
    $stmt = $mysqli->prepare("SELECT * FROM INVOICES WHERE (SENDER=? AND RECIPIENT=?) or (RECIPIENT=? and SENDER=?)");
    $stmt->bind_param("ssss",$userID,$filterID,$userID,$filterID);
    $stmt->execute();
    $invoices=$stmt->get_result();
}
$invoicesInfo = [];
$invoiceIDs = [];
while ($invoice = $invoices->fetch_assoc()) {
    array_push($invoicesInfo,$invoice);
    array_push($invoiceIDs, '"'.$invoice["INVOICE_ID"].'"');
}
$noInvoices = $invoices->num_rows == 0;
if (!$noInvoices) {
    // this was giving trouble when converting to a prepared statement and theres also no point as it is server generated ids from the db so there is no attack surface
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