<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Username</title>
    <link rel="stylesheet" href="username.css">
</head>
<body>
    <main>
        <section id="changeusername" class="page">
            <!-- Image Group for 404 Not Found Logos -->
            <div class="img-group">
                <img src="../img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
                <img src="../img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
            </div>
            <div class="center-text">
                <h1>404 Not Found Application</h1>
            </div>
            <div class="message">
                <h4>Please enter your new username below.</h4>
            </div>
            <!-- Form for Change Username -->
            <form action="change_username.php" method="POST">
                <input type="text" id="username" name="newNickname" required placeholder="New Username">
                <br>
                <!-- Button Group -->
                <div class="button-group">
                    <button type="submit">Change Username</button>
                    <button type="button" onclick="window.history.back()">Back</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>