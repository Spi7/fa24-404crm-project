<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- ensure compatibility w/ older version of Internet Explorer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- makes pg responsive, adjust its width based on device's secreen size -->
    <title>CRM Dashboard (404)</title> <!-- our title -->
    <link rel="stylesheet" href="addevent.css"> <!-- Link to external CSS file -->
</head>
    <body>
        <header>
            <div class='back-calendar'>
                <a href="calendar.php">
                    <img src="../img/calendar-icon.png" alt="Calendar">
                </a>
            </div>
            <div class="profile-button">
                <a href="../profile/userinfo.php">
                    <img src="../img/user profile icon.png" alt="Profile">
                </a>
            </div>
        </header>
        <div class="form-container">
            <div class="form-title"> Schedule An Event</div>
            <form action="scheduler_send_invite.php" method="post" id="event-form">
                <div class="form-group">
                    <label for="select-event">Select Event</label>
                    <select id="select-event" name="select-event">
                    <?php
                    // Include the database connection
                    include('../db_connection.php');
                    connectDB();

                    // get user_id to fetch only their events
                    fetchUserData();
                    $user_id = $user['USER_ID'];

                    // Fetch events from the database
                    $query = "SELECT EVENT_ID, TITLE FROM CALENDARS WHERE USER_ID='$user_id'";
                    $result = $mysqli->query($query);

                    // Check if the query executed successfully
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['EVENT_ID']}'>{$row['TITLE']}</option>";
                        }
                    } else {
                        echo "<option value=''>No events found</option>";
                    }
                    ?>
                </select>
                </div>
                <div class="form-group">
                    <label for="select-contact">Select Contact</label>
                    <select id="select-contact" name="select-contact">
                    <?php
                    // Include the database connection
                    include('../db_connection.php');
                    connectDB();

                    // get user_id to fetch only their events
                    fetchUserData();
                    $user_id = $user['USER_ID'];

                    // Fetch events from the database
                    $query = "SELECT CONTACT_ID FROM CONTACTS WHERE CURRENT_USER_ID='$user_id'";
                    $result = $mysqli->query($query);

                    // Check if the query executed successfully
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['CONTACT_ID']}'>{$row['CONTACT_ID']}</option>";
                        }
                    } else {
                        echo "<option value=''>No contacts found</option>";
                    }
                    ?>
                </select>
                </div>
                <button type="submit">Send Invite</button>
            </form>
        </div>
    </body>
</html>
