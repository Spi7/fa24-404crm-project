<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management</title>
    <link rel="stylesheet" href="new.css">
    <script src="script.js" defer></script>
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
            <form id="delete-team-form">
                <label for="confirm-team-name">Type the team name to confirm deletion:</label>
                <input type="text" id="confirm-team-name" name="confirm-team-name" placeholder="Enter team name for confirmation" required>

                <button type="submit" class="delete-btn">Delete Team</button>
            </form>
        </section>
    </div>
</body>

<script>
    document.getElementById('delete-team-form').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the form from submitting
    const teamName = document.getElementById('confirm-team-name').value;

    if (teamName) {
        const confirmation = confirm(`You are about to permanently delete the team: "${teamName}". This action cannot be undone. Are you sure you want to proceed?`);
        if (confirmation) {
            // Proceed with deletion (this is where back-end integration would go)
            alert(`Team "${teamName}" has been successfully deleted.`);  // Replace with actual delete logic later
        }
    } else {
        alert('Please enter the team name to confirm deletion.');
    }
});

</script>
</html>
