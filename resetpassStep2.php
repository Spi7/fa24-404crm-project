<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/resetpass2.css">
</head>

<body>
    <main>
        <section id="resetpassword" class="page"> <!-- using the same css as first page-->
            <!-- Image Group for 404 Not Found Logos -->
            <div class="img-group">
                <img src="img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
                <img src="img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
            </div>
            <div class="center-text">
                <h1>404 Not Found Application</h1>
            </div>
            <div class="message">
                <h4>Step 2: Please enter your reset token and new password in the corresponding boxes.</h4>
            </div>
            <!-- Form for Reset Password -->
            <form>
                <!-- for each of the name, please check if it correspond to our database -->
                <input type="text" id="token" name="token" required placeholder="Enter your reset token here">
                <br>
                <input type="password" id="new_pass" name="password" required placeholder="New Password">
                <br>
                <input type="password" id="confirm_pass" name="confirmPassword" required placeholder="Confirm Password">
                <br>
                <p style="color:#f00" id="error"></p>
                <!-- Button Group -->
                <div class="button-group">
                    <button type="button" onclick="sendResetParams()">Reset Password</button>
                    <button type="button" onclick="window.history.back()">Back</button>
                </div>
            </form>
        </section>
    </main>
    <script>
        // JavaScript to validate the email input
        // check if this code to be use & valid for testing
        function sendResetParams() {
            var token = document.getElementById("token").value;
            var newPass = document.getElementById("new_pass").value;
            var confirmPass = document.getElementById("confirm_pass").value;
            if (newPass == confirmPass) {
                let formData = new FormData();
                formData.append('token', token);
                formData.append('password',newPass)
                formData.append('confirmPassword',newPass)

                fetch("/resetpassBackend.php", {
                    body: formData,
                    method: "post"
                }).then(res => res.text())
                    .then(text => {
                        if (text == "DONE") {
                            location = "/login.html"
                        } else {
                            document.querySelector("#error").innerHTML = text
                        }
                    })
            } else {
                document.querySelector("#error").innerHTML = "passwords need to match"
            }
        }
    </script>
</body>

</html>