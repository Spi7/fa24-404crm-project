<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

    include "../db_connection.php";
    connectDB();
    $userIDQuery = $mysqli->query("SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN='$_COOKIE[SESSION_TOKEN]'");
    if ($userIDQuery->num_rows == 0) {
        die ("error session token not found");
    }
    $userID = $userIDQuery->fetch_assoc()["USER_ID"];
    //get dest id - already checked there is a row before
    $invoices= $mysqli->query("SELECT INVOICE_ID FROM INVOICES WHERE SENDER='$userID' or RECIPIENT='$userID'");
    $invoiceIDs=[];
    while( $invoiceID = $invoices->fetch_column(0) ) {
        array_push($invoiceIDs,$invoiceID);
    }
    $invoicesInfo= $mysqli->query("SELECT * FROM INVOICES WHERE SENDER='$userID' or RECIPIENT='$userID'");
    $invoiceItems = $mysqli->query("SELECT * FROM INVOICE_ITEMS WHERE INVOICE_ID IN (" . implode(',',$invoiceIDs) . ")");
    

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- ensure compatibility w/ older version of Internet Explorer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- makes pg responsive, adjust its width based on device's secreen size -->
    <title>CRM Dashboard (404)</title> <!-- our title -->
    <link rel="stylesheet" href="invoice.css"> <!-- Link to external CSS file -->
</head>

<body>
<a href="../home-page/home.php">
        <img id="homeButton" src="../img/home.png" alt="Home">
        <p>Home</p>
    </a>
    <div id="main-container">
        <h1>invoices involving you</h1>
        <table>
            <tr>
                <th>Invoice ID</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Created</th>
                <th>Due</th>
                <th>Description</th>
            </tr>
            <?php
            
            while($row=$invoicesInfo->fetch_row()){
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>".$value."</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <h1>invoice items involving your invoices</h1>
        <table>
            <tr>
                <th>Item ID</th>
                <th>Invoice ID</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
            <?php
            
            while($row=$invoiceItems->fetch_row()){
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>".$value."</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>