<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- ensure compatibility w/ older version of Internet Explorer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- makes pg responsive, adjust its width based on device's secreen size -->
    <title>CRM Dashboard (404)</title> <!-- our title -->
    <link rel="stylesheet" href="css/userinfo.css"> <!-- Link to external CSS file -->
</head>
<body>
        <!-- get profile info -->

    <?php include 'profile.php';?>
    <header> <!-- define the top section of the web page, WEBLOGO?/Title/Navigation page -->
        <div class="header-content">
            <h1>Welcome, User</h1> <!-- in the future, we can do dynamic change of "User" to like the person's user name who logined -->
            <p><?php echo date("F j, Y");?></p> <!-- Display the current date -->
            <div class="user-profile">
                <input type="text" placeholder="Search"> <!-- Search bar input field -->
                <div class="profile-icon">
                    <!-- You can add an image or icon here for the user -->
                    <img src="img/user profile icon.png" alt="Profile Icon">
                </div>
            </div>
        </div>
    </header>

    <aside>
        <div class="sidebar"> <!-- representing different functional block for main board -->
            <!-- Calendar -->
            <div class="sidebar calendar">
                <img src="img/calendar-icon.png" alt="Calendar">
                <p>Calendar</p>
            </div>

            <!-- Chat -->
            <div class="sidebar chat">
                <img src="img/chat-icon.png" alt="Chat">
                <p>Chat</p>
            </div>

            <!-- Projects -->
            <div class="sidebar projects">
                <img src="img/project-icon.png" alt="Projects">
                <p>Projects</p>
            </div>

            <!-- Invoice -->
            <div class="sidebar invoice">
                <img src="img/invoice-icon.png" alt="Invoice">
                <p>Invoice</p>
            </div>
        </div>
</aside>

<main>
        <div class="profile-pic">
                    <img src="img/user profile icon.png" alt="Profile Icon">
                    <label>User</label>
                    <label>Email:</label>
        </div>
        <div class="profile-info">
        <div >
            <label>First Name</label>
            <div class="rectangle"><?php echo $user["FIRST_NAME"] ?></div>
        </div>
        <div >
            <label>Last Name</label>
            <div class="rectangle"><?php echo $user["LAST_NAME"] ?></div>
        </div>
        <div >
            <label>Gender</label>
            <div class="rectangle"><?php echo $user["GENDER"] ?></div>
        </div>
        <div >
            <label>Country</label>
            <div class="rectangle"><?php echo $user["COUNTRY"] ?></div>
        </div>
        <div >
            <label>Language</label>
            <div class="rectangle"><?php echo $user["LANGUAGE"] ?></div>
        </div>
        <div >
            <label>Time Zone</label>
            <div class="rectangle"><?php echo $user["TIMEZONE"] ?></div>
        </div>
        </div>
    </main>

</body>
</html>