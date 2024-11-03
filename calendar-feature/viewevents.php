<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- ensure compatibility w/ older version of Internet Explorer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- makes pg responsive, adjust its width based on device's secreen size -->
    <title>CRM Dashboard (404)</title> <!-- our title -->
    <link rel="stylesheet" href="viewevents.css"> <!-- Link to external CSS file -->
</head>
<body>
    <header>
        <div class='back-calendar'>
            <a href="calendar.php">
                <img src="../img/calendar-icon.png" alt="Calendar">
            </a>
        </div>
        <div class="profile-button">
                <a href="../profile/profile.php">
                    <img src="../img/user profile icon.png" alt="Profile">
                </a>
            </div>
        <?php
            $month = $_GET['month'];
            $year = $_GET['year'];
            echo "<h1>$month $year events</h1>";
        ?>
    </header>
    <div class="stack-events" id="stack-events">
    </div>
    <script>
        window.month = <?php echo json_encode($month); ?>;
        window.year = <?php echo json_encode($year); ?>;
    </script>
    <script src="viewevents.js"></script>
</body>
</html>
