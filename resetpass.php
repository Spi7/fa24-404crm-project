<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/resetpass.css">
</head>
<body>
    <main>
        <section id="resetpassword" class="page">
            <!-- Image Group for 404 Not Found Logos -->
            <div class="img-group">
                <img src="img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
                <img src="img/404 not found Abous Us.jpg" alt="404 Not Found Logo">
            </div>
            <div class="center-text">
                <h1>404 Not Found Application</h1>
            </div>
            <div class="message">
                <h4>Step 1: Please enter your email. The following instructions will be send to your email.</h4>
            </div>
            <!-- Form for Reset Password -->
            <form>
                <input type="email" id="email" name="email" required placeholder="Email Address">
                <br>
                <p style="color:#f00" id="error"></p>
                <!-- Button Group -->
                <div class="button-group">
                    <button type="button" onclick="sendEmail()">Reset Password</button>
                    <button type="button" onclick="window.history.back()">Back</button>
                </div>
            </form>
        </section>
    </main>
    <script>
        // JavaScript to validate the email input
        // check if this code to be use & valid for testing
        function sendEmail() {
            var email = document.getElementById("email").value;
            
            // Basic email format validation (simple regex)
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false; // Prevent button action if email is invalid
            }
            let formData = new FormData();
            formData.append('email', email);
            //"/CSE442/2024-Fall/ubit/resetpassBackend.php"
            fetch("resetpassBackend.php",{
                body:formData,
                method:"post"
            }).then(res=>res.text())
            .then(text=>{
                if(text=="STEP2"){
                    // location="/CSE442/2024-Fall/ubit/resetpassStep2.php"
                    location="resetpassStep2.php"
                }else{
                document.querySelector("#error").innerHTML=text
                }
            })
        }
    </script>
</body>
</html>
