<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
if (count($_POST) > 0) {
    header(header: 'Content-Type: application/json; charset=utf-8');
    include "../db_connection.php";
    include "../notifications.php";
    connectDB();
    $quantities = $_POST["quantity"];
    $destEmail = strtolower($_POST["email"]);
    $prices = $_POST["price"];
    $descriptions = $_POST["description"];
    $finalPrice = 0;

    //check if user destination is in accounts db
    $userEmailQuery = $mysqli->query("SELECT USER_ID FROM ACCOUNTS WHERE EMAIL='$destEmail'");
    if (mysqli_num_rows($userEmailQuery) == 0) {
        echo json_encode(array("error" => "EMAIL_NOT_FOUND"));//{"error":"EMAIL_NOT_FOUND"}
        exit(0);
    }
    //get invoice id - max id + 1
    $invoiceID = (int) $mysqli->query("SELECT MAX(INVOICE_ID) as max FROM INVOICES")->fetch_assoc()["max"] + 1;
    //get sender - get user id where session token = the cookie variable
    $senderID = $mysqli->query("SELECT USER_ID FROM ACCOUNTS WHERE SESSION_TOKEN='$_COOKIE[SESSION_TOKEN]'")->fetch_assoc()["USER_ID"];
    //get dest id - already checked there is a row before
    $destUserId = $userEmailQuery->fetch_assoc()["USER_ID"];
    $mysqli->query(query: "INSERT INTO INVOICES VALUES ('$invoiceID','$senderID','$destUserId',now(),'$_POST[invoiceDueDate]','$_POST[invoiceName]','$_POST[invoiceBA]')");
    createNotification($senderID, $destUserId, 'INVOICES', $invoiceID);
    for ($i = 0; $i < count(value: $quantities); $i++) {
        $invoiceItemID = (int) $mysqli->query("SELECT MAX(ITEM_ID) as max FROM INVOICE_ITEMS")->fetch_assoc()["max"] + 1;
        $mysqli->query("INSERT INTO INVOICE_ITEMS VALUES ('$invoiceItemID','$invoiceID','$quantities[$i]','$prices[$i]','$descriptions[$i]')");
    } 
    echo json_encode(array("success" => "true"));
    exit();//if post dont respond with page
}
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
    </a>
    <div id="centerWrapper">
    <div class="main-container">
        <form action="invoice.php" method="post">
            <h1>Create a New Invoice</h1>
            <label class="headerLabel">
                Invoice Email Address<br>
                <input name="email" type="email" placeholder="recipient@client.org">
                <br>
                <span id="userNotFoundErr" class="errorText hide">user not found<br></span>

            </label>
            <label class="headerLabel">
                Invoice name<br>
                <input name="invoiceName" type="text">
                <br>
            </label>
            <br>
            <br>
            <label for="items" class="headerLabel" id="invItemsLabel">
                Invoice Items
            </label>

            <section name="items" id="invoiceItems">
            </section>
            <section style="text-align: center; margin: 8px 0;">
                <button id="addItemButton" onclick="addItemToForm()" type="button">Add item</button>
                <span id="invoicePriceDisplay">Total : ---</span>
            </section>
            <section id="baAndDateWrapper">
                <div id="invoiceBAWrapper"><label for="invoiceBA">Invoice Billing Address</label><br>
                    <textarea name="invoiceBA"></textarea>
                </div>
                <div id="dateWrapper">
                    <label for="invoiceDueDate">Invoice Due Date</label>
                    <br>
                    <input name="invoiceDueDate" type="date">
                </div>
            </section>
            <div style="text-align:center">
                <button id="submitButton" type="button" onclick="submitForm()">Send Invoice</button>
            </div>
            <p id="submitStatus" class="errorText"></p>
        </form>
    </div>
    </div>
    <a href="./invoices.php" class="button" id="viewInvoicesLink">View Invoices</a>
    <template id="itemTemplate">
        <fieldset class="item">
            <!-- new inputs will all have the same names quantity/price/description this will result to the server receiving an array of values for each -->
            <span class="itemNumber"></span>
            <label for="quantity">Quantity:</label>
            <input name="quantity[]" type="number" class="quantityInput">
            <label for="price">Price:</label>
            <input name="price[]" type="number" class="priceInput" step="any">
            <label for="description">desc:</label>
            <input name="description[]" type="text" class="descriptionInput">
            <button type="button" class="deleteItemButton">X</button>
        </fieldset>
    </template>
    <script src="invoice.js"></script>
</body>

</html>