<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management</title>
    <link rel="stylesheet" href="project management.css"> <!-- Assuming the file name has an underscore -->
</head>
<body>
    <div class="container">
        <h1>Team Management</h1>

        <!-- Assign Team Members Section -->
        <section class="section">
            <h2>Assign Team Members to Project</h2>
            <form action="assign_team_member.php" method="POST">
                <label for="project">Select Project:</label>
                <select id="project" name="project">
                    <?php
                    // Include the database connection
                    include('../db_connection.php');
                    connectDB();

                    // Fetch projects from the database
                    $query = "SELECT PROJECT_ID, TITLE FROM PROJECTS";
                    $result = $mysqli->query($query);

                    // Check if the query executed successfully
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['PROJECT_ID']}'>{$row['TITLE']}</option>";
                        }
                    } else {
                        echo "<option value=''>No projects found</option>";
                    }
                    ?>
                </select>

                <label for="team-member">Assign Team Member:</label>
                <select id="team-member" name="team-member">
                    <?php
                    // Fetch team members from the accounts table
                    $query = "SELECT USER_ID, FIRST_NAME, LAST_NAME FROM ACCOUNTS";
                    $result = $mysqli->query($query);

                    // Check if the query executed successfully
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['USER_ID']}'>{$row['FIRST_NAME']} {$row['LAST_NAME']}</option>";
                        }
                    } else {
                        echo "<option value=''>No team members found</option>";
                    }
                    ?>
                </select>

                <button type="submit">Assign Member</button>
            </form>
        </section>

        <!-- Create Team Section -->
        <section class="section">
            <h2>Create New Team</h2>
            <form action="create_team.php" method="POST">
                <label for="team-name">Team Name:</label>
                <input type="text" id="team-name" name="team-name" placeholder="Enter team name" required>

                <label for="team-members">Add Team Members:</label>
                <select id="team-members" name="team-members[]" multiple>
                    <?php
                    // Fetch users for assigning to a new team
                    $query = "SELECT USER_ID, FIRST_NAME, LAST_NAME FROM ACCOUNTS";
                    $result = $mysqli->query($query);

                    // Check if the query executed successfully
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['USER_ID']}'>{$row['FIRST_NAME']} {$row['LAST_NAME']}</option>";
                        }
                    } else {
                        echo "<option value=''>No users found</option>";
                    }
                    ?>
                </select>

                <button type="submit">Create Team</button>
            </form>
        </section>

        <!-- Delete Team Section -->
        <section class="section">
            <h2>Delete Team</h2>
            <form action="delete_team.php" method="POST">
                <label for="delete-team">Select Team to Delete:</label>
                <select id="delete-team" name="delete-team">
                    <option value="team1">Team 1</option>
                    <option value="team2">Team 2</option>
                    <!-- Existing teams from the database -->
                </select>

                <label for="confirm-team-name">Type the team name to confirm deletion:</label>
                <input type="text" id="confirm-team-name" name="confirm-team-name" placeholder="Enter team name for confirmation" required>

                <button type="submit" class="delete-btn">Delete Team</button>
            </form>
        </section>
        <!-- Back Button -->
        <section class="section">
            <button onclick="window.location.href='project.php'" class="back-btn">Back to Project</button>
        </section>
    </div>
</body>
</html>
