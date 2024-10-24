<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management</title>
    <link rel="stylesheet" href="project management.css">
</head>
<body>
    <div class="container">
        <h1>Team Management</h1>

        <!-- Assign Team Members Section -->
        <section class="section">
            <h2>Assign Team Members to Project</h2>
            <form>
                <label for="project">Select Project:</label>
                <select id="project" name="project">
                    <option value="project1">Project 1</option>
                    <option value="project2">Project 2</option>
                    <!-- Additional project options here -->
                </select>

                <label for="team-member">Assign Team Member:</label>
                <select id="team-member" name="team-member">
                    <option value="user1">User 1</option>
                    <option value="user2">User 2</option>
                    <!-- User options populated from the user database -->
                </select>

                <button type="submit">Assign Member</button>
            </form>
        </section>

        <!-- Create Team Section -->
        <section class="section">
            <h2>Create New Team</h2>
            <form>
                <label for="team-name">Team Name:</label>
                <input type="text" id="team-name" name="team-name" placeholder="Enter team name" required>

                <label for="team-members">Add Team Members:</label>
                <select id="team-members" name="team-members" multiple>
                    <option value="user1">User 1</option>
                    <option value="user2">User 2</option>
                    <!-- User options populated from the user database -->
                </select>

                <button type="submit">Create Team</button>
            </form>
        </section>

        <!-- Delete Team Section -->
        <section class="section">
            <h2>Delete Team</h2>
            <form>
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
    </div>
</body>
</html>

