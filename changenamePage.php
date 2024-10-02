<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Username Change</title>
    <link rel="stylesheet" href="css/changeusername.css">
</head>
<body>
    <main>
        <section id="confirmusername" class="page">
            <!-- Image Group for 404 Not Found Logos -->
            <div class="img-group">
                <img src="img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
                <img src="img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
            </div>
            <div class="center-text">
                <h1>404 Not Found Application</h1>
            </div>
            <div class="message">
                <h4>Please confirm your new username.</h4>
            </div>
            <!-- Form for Confirming Change of Username -->
            <form method="POST" action="change-username-handler.php">
                <!-- Enter New Username -->
                <input type="text" id="new_username" name="new_username" required placeholder="Enter New Username">
                <br>
                <!-- Confirm New Username -->
                <input type="text" id="confirm_username" name="confirm_username" required placeholder="Confirm New Username">
                <br>
                <!-- Hidden Token Field -->
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <!-- Button Group -->
                <div class="button-group">
                    <button type="submit">Confirm</button>
                    <button type="button" onclick="window.history.back()">Cancel</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
