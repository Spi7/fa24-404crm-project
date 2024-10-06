<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <link rel="stylesheet" href="project.css"> <!-- Link to the external CSS file -->
</head>
<body>

<div class="container">
    <?php include '../sidebar.php'; ?> <!-- Including the sidebar.php file -->

    <div class="main-content">
        <div class="header">
            <h1>Project #1 Overview</h1>

            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-bar" id="progress-bar" style="width: 0%;"></div> <!-- Progress Bar -->
            </div>
            <span id="progress-text">Progress: 0%</span>
        </div>

        <!-- Task List -->
        <ul class="task-list">
            <li data-task="1" data-done="false" onclick="showTask(1)">Task #1: Design UI</li>
            <li data-task="2" data-done="false" onclick="showTask(2)">Task #2: Implement Frontend</li>
            <li data-task="3" data-done="false" onclick="showTask(3)">Task #3: Backend Integration</li>
            <li data-task="4" data-done="false" onclick="showTask(4)">Task #4: Testing & Debugging</li>
            <li data-task="5" data-done="false" onclick="showTask(5)">Task #5: Final Deployment</li>
        </ul>

        <!-- Task 1 Details with Mini Progress Bar -->
        <div id="task-details-1" class="task-details">
            <h3>Task #1 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Create a responsive and user-friendly UI for the project management interface.</p>
            <ul>
                <li>1.Design the project layout.</li>
                <li>2.Ensure mobile responsiveness.</li>
                <li>3.Implement the sidebar and main content sections.</li>
            </ul>

            <!-- Mini Progress Bar for Task 1 -->
            <div class="mini-progress-bar">
                <div class="mini-progress" id="mini-progress-1"></div>
            </div>
            <span class="mini-progress-percentage" id="mini-progress-percent-1">Progress: 0%</span>

            <!-- Subtask Buttons for Task 1 -->
            <button class="subtask-button" id="subtask-1-1" data-completed="false" onclick="completeSubtask(1, 1)">Mark Subtask 1 as Done</button>
            <button class="subtask-button" id="subtask-1-2" data-completed="false" onclick="completeSubtask(1, 2)">Mark Subtask 2 as Done</button>
            <button class="subtask-button" id="subtask-1-3" data-completed="false" onclick="completeSubtask(1, 3)">Mark Subtask 3 as Done</button>
        </div>

        <!-- Task 2 Details with Mini Progress Bar -->
        <div id="task-details-2" class="task-details">
            <h3>Task #2 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Implement the front-end functionality and connect it to the backend API.</p>
            <ul>
                <li>1.Create forms for user inputs.</li>
                <li>2.Ensure the layout matches the design mockups.</li>
                <li>3.Connect the front-end to backend services.</li>
            </ul>

            <!-- Mini Progress Bar for Task 2 -->
            <div class="mini-progress-bar">
                <div class="mini-progress" id="mini-progress-2"></div>
            </div>
            <span class="mini-progress-percentage" id="mini-progress-percent-2">Progress: 0%</span>

            <!-- Subtask Buttons for Task 2 -->
            <button class="subtask-button" id="subtask-2-1" data-completed="false" onclick="completeSubtask(2, 1)">Mark Subtask 1 as Done</button>
            <button class="subtask-button" id="subtask-2-2" data-completed="false" onclick="completeSubtask(2, 2)">Mark Subtask 2 as Done</button>
            <button class="subtask-button" id="subtask-2-3" data-completed="false" onclick="completeSubtask(2, 3)">Mark Subtask 3 as Done</button>
        </div>

        <!-- Task 3 Details with Mini Progress Bar -->
        <div id="task-details-3" class="task-details">
            <h3>Task #3 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Build backend logic for the project management app.</p>
            <ul>
                <li>1.Develop APIs for data handling.</li>
                <li>2.Set up database schema for tasks and projects.</li>
                <li>3.Test backend endpoints.</li>
            </ul>

            <!-- Mini Progress Bar for Task 3 -->
            <div class="mini-progress-bar">
                <div class="mini-progress" id="mini-progress-3"></div>
            </div>
            <span class="mini-progress-percentage" id="mini-progress-percent-3">Progress: 0%</span>

            <!-- Subtask Buttons for Task 3 -->
            <button class="subtask-button" id="subtask-3-1" data-completed="false" onclick="completeSubtask(3, 1)">Mark Subtask 1 as Done</button>
            <button class="subtask-button" id="subtask-3-2" data-completed="false" onclick="completeSubtask(3, 2)">Mark Subtask 2 as Done</button>
            <button class="subtask-button" id="subtask-3-3" data-completed="false" onclick="completeSubtask(3, 3)">Mark Subtask 3 as Done</button>
        </div>

        <!-- Task 4 Details with Mini Progress Bar -->
        <div id="task-details-4" class="task-details">
            <h3>Task #4 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Conduct testing and debugging of the project management interface.</p>
            <ul>
                <li>1.Test each feature for bugs.</li>
                <li>2.Conduct usability testing with a small group of users.</li>
                <li>3.Document any issues found and fix them.</li>
            </ul>

            <!-- Mini Progress Bar for Task 4 -->
            <div class="mini-progress-bar">
                <div class="mini-progress" id="mini-progress-4"></div>
            </div>
            <span class="mini-progress-percentage" id="mini-progress-percent-4">Progress: 0%</span>

            <!-- Subtask Buttons for Task 4 -->
            <button class="subtask-button" id="subtask-4-1" data-completed="false" onclick="completeSubtask(4, 1)">Mark Subtask 1 as Done</button>
            <button class="subtask-button" id="subtask-4-2" data-completed="false" onclick="completeSubtask(4, 2)">Mark Subtask 2 as Done</button>
            <button class="subtask-button" id="subtask-4-3" data-completed="false" onclick="completeSubtask(4, 3)">Mark Subtask 3 as Done</button>
        </div>

        <!-- Task 5 Details with Mini Progress Bar -->
        <div id="task-details-5" class="task-details">
            <h3>Task #5 Details</h3>
            <p>Assigned To: Employee Name (employee@company.com)</p>
            <p>Task Description: Deploy the project and ensure it's fully functional.</p>
            <ul>
                <li>1.Set up the server for deployment.</li>
                <li>2.Deploy the project to the production environment.</li>
                <li>3.Ensure everything works as expected.</li>
            </ul>

            <!-- Mini Progress Bar for Task 5 -->
            <div class="mini-progress-bar">
                <div class="mini-progress" id="mini-progress-5"></div>
            </div>
            <span class="mini-progress-percentage" id="mini-progress-percent-5">Progress: 0%</span>

            <!-- Subtask Buttons for Task 5 -->
            <button class="subtask-button" id="subtask-5-1" data-completed="false" onclick="completeSubtask(5, 1)">Mark Subtask 1 as Done</button>
            <button class="subtask-button" id="subtask-5-2" data-completed="false" onclick="completeSubtask(5, 2)">Mark Subtask 2 as Done</button>
            <button class="subtask-button" id="subtask-5-3" data-completed="false" onclick="completeSubtask(5, 3)">Mark Subtask 3 as Done</button>
        </div>
    </div>
</div>

<script>
    // Function to show task details when a task is clicked
    function showTask(taskNumber) {
        const tasks = document.querySelectorAll('.task-details');
        tasks.forEach(task => task.style.display = 'none');

        const taskListItems = document.querySelectorAll('.task-list li');
        taskListItems.forEach(item => item.classList.remove('active-task'));

        const taskDetails = document.getElementById('task-details-' + taskNumber);
        taskDetails.style.display = 'block';

        taskListItems[taskNumber - 1].classList.add('active-task');
    }

    // Function to complete a subtask and update mini progress bar
    function completeSubtask(taskNumber, subtaskNumber) {
        const subtaskButton = document.getElementById('subtask-' + taskNumber + '-' + subtaskNumber);
        const isCompleted = subtaskButton.getAttribute('data-completed') === 'true';
        const miniProgressBar = document.getElementById('mini-progress-' + taskNumber);
        const miniProgressPercent = document.getElementById('mini-progress-percent-' + taskNumber);
        let completedSubtasks = miniProgressBar.getAttribute('data-completed-subtasks') || 0;
        completedSubtasks = parseInt(completedSubtasks);

        if (!isCompleted && completedSubtasks < 3) {
            completedSubtasks++;
            subtaskButton.setAttribute('data-completed', 'true');
            subtaskButton.textContent = `Subtask ${subtaskNumber} Completed`;
            subtaskButton.classList.add('completed');
        } else if (isCompleted && completedSubtasks > 0) {
            completedSubtasks--;
            subtaskButton.setAttribute('data-completed', 'false');
            subtaskButton.textContent = `Mark Subtask ${subtaskNumber} as Done`;
            subtaskButton.classList.remove('completed');
        }

        const progressPercent = (completedSubtasks / 3) * 100;
        miniProgressBar.style.width = progressPercent + '%';
        miniProgressBar.setAttribute('data-completed-subtasks', completedSubtasks);
        miniProgressPercent.textContent = `Progress: ${Math.round(progressPercent)}%`;

        // If all subtasks are done, mark task as done and update the total project progress
        if (completedSubtasks === 3) {
            markTaskAsDone(taskNumber);
        } else if (completedSubtasks < 3) {
            unmarkTaskAsDone(taskNumber);
        }
    }

    // Function to mark a task as done and update the overall progress
    function markTaskAsDone(taskNumber) {
        const taskItem = document.querySelector(`[data-task="${taskNumber}"]`);
        taskItem.setAttribute('data-done', 'true');
        updateProgress();
    }

    // Function to unmark a task as done and update the overall progress
    function unmarkTaskAsDone(taskNumber) {
        const taskItem = document.querySelector(`[data-task="${taskNumber}"]`);
        taskItem.setAttribute('data-done', 'false');
        updateProgress();
    }

    // Function to update overall project progress
    function updateProgress() {
        const tasks = document.querySelectorAll('.task-list li');
        let completedTasks = 0;

        tasks.forEach(task => {
            if (task.getAttribute('data-done') === 'true') {
                completedTasks++;
            }
        });

        const progressPercent = (completedTasks / tasks.length) * 100;
        document.getElementById('progress-bar').style.width = progressPercent + '%';
        document.getElementById('progress-text').textContent = 'Progress: ' + progressPercent + '%';
    }

    // Initially show the first task's details
    showTask(1);
</script>

</body>
</html>
