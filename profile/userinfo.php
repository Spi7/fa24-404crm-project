<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Dashboard (404)</title>
    <link rel="stylesheet" href="userinfo.css">
    <script>
        function checkSidebarVisibility() {
            const sidebar = document.querySelector('.sidebar');
            if (window.innerWidth < 600) {
                if (sidebar) {
                    sidebar.style.display = 'none';
                }
            } else {
                if (sidebar) {
                    sidebar.style.display = 'flex'; // or whatever display style you need
                }
            }
        }

        window.onload = checkSidebarVisibility; // Check on load
        window.onresize = checkSidebarVisibility; // Check on resize
    </script>
</head>
<body>
    <?php include 'profile.php';?>
    <header>
        <div class="header-content">
            <h1>Welcome, User</h1>
            <p><?php echo date("F j, Y");?></p>
            <div class="user-profile">
                <input type="text" placeholder="Search">
                <div class="profile-icon">
                    <img src="../img/user profile icon.png" alt="Profile Icon">
                </div>
            </div>
        </div>
    </header>

    <div class="userinfo-container">
        <div id="sidebar-container"></div> <!-- Placeholder for the sidebar -->
        
        <script>
            // Check screen width and include sidebar if greater than 600px
            if (window.innerWidth > 600) {
                const sidebarContainer = document.getElementById('sidebar-container');
                fetch('../sidebar.php')
                    .then(response => response.text())
                    .then(data => {
                        sidebarContainer.innerHTML = data; // Insert sidebar HTML
                    });
            }
        </script>

        <div class="profile-info">
            <div class="profile-pic">
                <button class="blue-button" onclick="window.location.href='username.php';">Change Username</button>
                <img src="../img/user profile icon.png" alt="Profile Icon">
                <label>User</label>
                <label>Email:</label>
            </div>
            <div>
                <label>First Name</label>
                <div class="rectangle"><?php echo $user["FIRST_NAME"] ?></div>
            </div>
            <div>
                <label>Last Name</label>
                <div class="rectangle"><?php echo $user["LAST_NAME"] ?></div>
            </div>
            <div>
                <label>Gender</label>
                <div class="rectangle"><?php echo $user["GENDER"] ?></div>
            </div>
            <div>
                <label>Country</label>
                <div class="rectangle"><?php echo $user["COUNTRY"] ?></div>
            </div>
            <div>
                <label>Language</label>
                <div class="rectangle"><?php echo $user["LANGUAGE"] ?></div>
            </div>
            <div>
                <label>Time Zone</label>
                <div class="rectangle"><?php echo $user["TIMEZONE"] ?></div>
            </div>
        </div>
    </div>
</body>
</html>

