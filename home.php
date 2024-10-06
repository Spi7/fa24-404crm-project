<!DOCTYPE html>
<html lang="en"> <!-- set the language to eng -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- ensure compatibility w/ older version of Internet Explorer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- makes pg responsive, adjust its width based on device's secreen size -->
    <title>CRM Dashboard (404)</title> <!-- our title --> 
    <link rel="stylesheet" href="css/homestyles.css"> <!-- Link to external CSS file -->
</head>
<body>
    <header> <!-- define the top section of the web page, WEBLOGO?/Title/Navigation page -->
        <div class="header-content">
            <h1>Welcome, User</h1> <!-- in the future, we can do dynamic change of "User" to like the person's user name who logined -->
            <p><?php echo date("F j, Y"); ?></p> <!-- Display the current date -->
            <div class="user-profile">
                <input type="text" placeholder="Search"> <!-- Search bar input field -->
                <div class="profile-icon">
                    <!-- You can add an image or icon here for the user -->
                    <a href=userinfo.php><img src="img/user profile icon.png" alt="Profile Icon"></a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="dashboard-grid"> <!-- representing different functional block for main board -->
            <!-- Calendar -->
            <div class="dashboard-item calendar" onclick="navigateToCalendar()">
                <img src="img/calendar-icon.png" alt="Calendar">
                <p>Calendar</p>
            </div>
            
            <!-- Chat -->
            <div class="dashboard-item chat" onclick="navigateToChat()">
                <img src="img/chat-icon.png" alt="Chat">
                <p>Chat</p>  
            </div>
            
            <!-- Projects -->
            <div class="dashboard-item projects" onclick="navigateToProject()">
                <img src="img/project-icon.png" alt="Projects">
                <p>Projects</p>
            </div>
            
            <!-- Invoice -->
            <div class="dashboard-item invoice" onclick="navigateToInvoice()">
                <img src="img/invoice-icon.png" alt="Invoice">
                <p>Invoice</p>
            </div>
        </div>

        <!-- Optional: You can place the 404 image or other content here -->
        <div class="logo-404">
            <img src="img/404 not found.png" alt="404 Not Found">
        </div>
        <button onclick="logout()">Log out</button>
    </main>
    <script>
        function logout(){
            document.cookie=""
            location.href="login.html"
        }
    </script>
</body>
</html>

<!-- JavaScript code below, link to each item -->
<script>
    function navigateToProject() {
        window.location.href = "project.php";
    }

    function navigateToChat() {
        window.location.href = "chat.php";
    }

    function navigateToCalendar() {
        window.location.href = "calendar.php";
    }

    function navigateToInvoice() {
        window.location.href = "invoice.php";
    }
</script>
