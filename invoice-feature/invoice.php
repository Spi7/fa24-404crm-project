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
    <?php include '../sidebar.php'; ?>
    <div class="main-container">
        <h1>Create a New Invoice</h1>
        <form action="invoice.php" method="post">
            <label class="headerLabel">
                Invoice Email Address<br>
                <input name="email" type="email" placeholder="recipient@client.org">
            </label>
            <br>
            <label for="items" class="headerLabel" id="invItemsLabel">
                Invoice Items
            </label>

            <section name="items" id="invoiceItems">
            </section>
            <section style="text-align: center;">
                <button id="addItemButton" onclick="addItemToForm()" type="button">Add item</button>
                <span id="invoicePriceDisplay">Total : ---</span>
            </section>
            <section id="baAndDateWrapper">
                <div id="invoiceBAWrapper"><label for="invoiceBA">Invoice Billing Address</label><br>
                    <textarea name="invoiceBA"></textarea>
                </div>
                <div id="dateWrapper">
                    <label for="invoiceCreatedDate">Invoice Created Date</label>
                    <br>
                    <input name="invoiceCreatedDate"type="date">
                    <br>
                    <label for="invoiceDueDate">Invoice Due Date</label>
                    <br>
                    <input name="invoiceDueDate" type="date">
                </div>
            </section>
            <div style="text-align:center">
                <button type="submit">Send Invoice</button>
            </div>
        </form>
    </div>
    <template id="itemTemplate">
        <fieldset class="item">
            <!-- new inputs will all have the same names quantity/price/description this will result to the server receiving an array of values for each -->
            <span class="itemNumber"></span>
            <label for="quantity">Quantity:</label>
            <input name="quantity[]" type="number" class="quantityInput">
            <label for="price">Price:</label>
            <input name="price[]" type="number" class="priceInput" step="any">
            <label for="description">Description:</label>
            <input name="description[]" type="text" class="descriptionInput">
            <button type="button" class="deleteItemButton">X</button>
        </fieldset>
    </template>
    <script src="invoice.js"></script>
</body>

</html>