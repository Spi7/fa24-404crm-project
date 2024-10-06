<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <link rel="stylesheet" href="project.css"> <!-- Link to the external CSS file -->
    <style>
        /* Optional: Style for active task */
        .active-task {
            font-weight: bold;
            color: #333;
        }

        /* Optional: Hide task details by default */
        .task-details {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <?php include '../sidebar.php'; ?> <!-- Including the sidebar.php file -->

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Project #1 Overview</h1>

            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-bar" style="width: 50%;"></div> <!-- Example Progress -->
            </div>
            <span>Progress: 50%</span>
        </div>

        <!-- Task List -->
        <ul class="task-list">
            <li onclick="showTask(1)">Task #1: Design UI</li>
            <li onclick="showTask(2)">Task #2: Implement Frontend</li>
            <li onclick="showTask(3)">Task #3: Backend Integration</li>
            <li onclick="showTask(4)">Task #4: Testing & Debugging</li>
            <li onclick="showTask(5)">Task #5: Final Deployment</li>
        </ul>

        <!-- Task Details -->
        <div id="task-details-1" class="task-details">
            <h3>Task #1 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Create a responsive and user-friendly UI for the project management interface.</p>
            <p>What you need to do to complete the task:</p>
            <ul>
                <li>Design the project layout.</li>
                <li>Ensure mobile responsiveness.</li>
                <li>Implement the sidebar and main content sections.</li>
            </ul>
            <button class="complete-button">Complete</button> <!-- This button is for UI purposes only, no functionality required -->
        </div>

        <div id="task-details-2" class="task-details">
            <h3>Task #2 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Implement the front-end functionality and connect it to the backend API.</p>
            <p>What you need to do to complete the task:</p>
            <ul>
                <li>Create forms for user inputs.</li>
                <li>Ensure the layout matches the design mockups.</li>
                <li>Connect the front-end to backend services.</li>
            </ul>
            <button class="complete-button">Complete</button>
        </div>

        <div id="task-details-3" class="task-details">
            <h3>Task #3 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Build backend logic for the project management app.</p>
            <p>What you need to do to complete the task:</p>
            <ul>
                <li>Develop APIs for data handling.</li>
                <li>Set up database schema for tasks and projects.</li>
                <li>Test backend endpoints.</li>
            </ul>
            <button class="complete-button">Complete</button>
        </div>

        <div id="task-details-4" class="task-details">
            <h3>Task #4 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Conduct testing and debugging of the project management interface.</p>
            <p>What you need to do to complete the task:</p>
            <ul>
                <li>Test each feature for bugs.</li>
                <li>Conduct usability testing with a small group of users.</li>
                <li>Document any issues found and fix them.</li>
            </ul>
            <button class="complete-button">Complete</button>
        </div>

        <div id="task-details-5" class="task-details">
            <h3>Task #5 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Deploy the project and ensure it's fully functional.</p>
            <p>What you need to do to complete the task:</p>
            <ul>
                <li>Set up the server for deployment.</li>
                <li>Deploy the project to the production environment.</li>
                <li>Ensure everything works as expected.</li>
            </ul>
            <button class="complete-button">Complete</button>
        </div>
    </div>
</div>

<script>
    // Function to show task details when a task is clicked
    function showTask(taskNumber) {
        // Hide all task details
        const tasks = document.querySelectorAll('.task-details');
        tasks.forEach(task => task.style.display = 'none');

        // Remove active-task class from all task list items
        const taskListItems = document.querySelectorAll('.task-list li');
        taskListItems.forEach(item => item.classList.remove('active-task'));

        // Show the selected task details
        const taskDetails = document.getElementById('task-details-' + taskNumber);
        taskDetails.style.display = 'block';

        // Add active-task class to the clicked task list item
        taskListItems[taskNumber - 1].classList.add('active-task');
    }

    // Initially show the first task's details
    showTask(1);
</script>

</body>
</html>
