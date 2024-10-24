<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <link rel="stylesheet" href="project.css"> <!-- Link to the external CSS file -->
    <script>
        // Function to load the mobile CSS and hide the sidebar if the screen width is mobile-sized
        function loadMobileCSS() {
            if (window.innerWidth <= 600) {
                // Create a link element for mobile CSS
                var mobileCss = document.createElement('link');
                mobileCss.rel = 'stylesheet';
                mobileCss.href = 'chat-mobile.css'; // Your mobile CSS file path

                // Append it to the head
                document.head.appendChild(mobileCss);

                // Hide the sidebar for mobile screens
                var sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.style.display = 'none'; // Hide the sidebar for mobile
                }
            }
        }
        // Run this when the page loads
        window.onload = loadMobileCSS;

        // Also check when the window is resized (optional)
        window.onresize = loadMobileCSS;
    </script>
</head>
<body>
<a href="../home-page/home.php">
        <img id="homeButton" src="../img/home.png" alt="Home">
        <p>Home</p>
    </a>
<div class="container">
    <?php include '../sidebar.php'; ?> <!-- Including the sidebar.php file -->
    <div class="main-content">
        <div class="header">
            <h1 id="project-title">Project #1 Overview</h1>
            <button class="top-right-button" onclick="location.href='project management.php'">Project management</button>

            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-bar" id="progress-bar" style="width: 0%;"></div> <!-- Progress Bar -->
            </div>
            <span id="progress-text">Progress: 0%</span>

            <!-- Project Switcher -->
            <div class="project-switcher">
                <button onclick="switchProject(1)">Project #1</button>
                <button onclick="switchProject(2)">Project #2</button>
                <button onclick="switchProject(3)">Project #3</button>
            </div>

            <!-- Add Task Button -->
            <button class="add-task-button" onclick="addTask()">Add Task</button>
        </div>

        <!-- Task List -->
        <ul class="task-list" id="task-list">
            <!-- Tasks will be dynamically loaded here -->
        </ul>

        <!-- Task Details (will be shown dynamically) -->
        <div id="task-details-container"></div>

    </div>
</div>

<script>
    let currentProject = 1; // Default to Project 1
    let taskCounter = {1: 4, 2: 3, 3: 3}; // Counter for new task numbers in each project
    let projectData = {
        1: {
            tasks: [
                { number: 1, name: "Design UI", subtasks: [false, false, false], done: false },
                { number: 2, name: "Implement Frontend", subtasks: [false, false, false], done: false },
                { number: 3, name: "Backend Integration", subtasks: [false, false, false], done: false }
            ],
            progress: 0
        },
        2: {
            tasks: [
                { number: 1, name: "Initial Planning", subtasks: [false, false, false], done: false },
                { number: 2, name: "Resource Allocation", subtasks: [false, false, false], done: false }
            ],
            progress: 0
        },
        3: {
            tasks: [
                { number: 1, name: "Set Up Database", subtasks: [false, false, false], done: false },
                { number: 2, name: "Implement Security", subtasks: [false, false, false], done: false }
            ],
            progress: 0
        }
    };

    // Function to switch between projects
    function switchProject(projectNumber) {
        currentProject = projectNumber;
        document.getElementById('project-title').textContent = `Project #${projectNumber} Overview`;

        // Load tasks for the selected project
        dynamicDisplay(projectNumber);
        updateProjectProgress();
    }

    // Function to dynamically display tasks for the current project
    function dynamicDisplay(projectNumber) {
        const taskList = document.getElementById('task-list');
        taskList.innerHTML = ''; // Clear task list
        const tasks = projectData[projectNumber].tasks;

        tasks.forEach(task => {
            const taskItem = document.createElement('li');
            taskItem.setAttribute('data-task', task.number);
            taskItem.textContent = `Task #${task.number}: ${task.name}`;
            taskItem.onclick = () => showTask(task.number);
            taskList.appendChild(taskItem);
        });
    }

    // Function to show task details
    function showTask(taskNumber) {
        const task = projectData[currentProject].tasks.find(t => t.number === taskNumber);
        const taskDetailsContainer = document.getElementById('task-details-container');
        taskDetailsContainer.innerHTML = ''; // Clear previous details

        const taskDetails = document.createElement('div');
        taskDetails.classList.add('task-details');
        taskDetails.innerHTML = `
            <h3>Task #${task.number} Details</h3>
            <p>Assigned To: Employee Name</p>
            <p>Task Description: ${task.name}</p>
            <ul>
                <li>1. Subtask 1</li>
                <li>2. Subtask 2</li>
                <li>3. Subtask 3</li>
            </ul>
            <div class="mini-progress-bar">
                <div class="mini-progress" id="mini-progress-${task.number}" style="width: ${calculateMiniProgress(task)}%;"></div>
            </div>
            <span class="mini-progress-percentage">Progress: ${calculateMiniProgress(task)}%</span>
            <button id="subtask-${task.number}-0" class="subtask-button ${task.subtasks[0] ? 'completed' : ''}" onclick="completeSubtask(${task.number}, 0)">
                ${task.subtasks[0] ? 'Subtask 1 Completed' : 'Mark Subtask 1 as Done'}
            </button>
            <button id="subtask-${task.number}-1" class="subtask-button ${task.subtasks[1] ? 'completed' : ''}" onclick="completeSubtask(${task.number}, 1)">
                ${task.subtasks[1] ? 'Subtask 2 Completed' : 'Mark Subtask 2 as Done'}
            </button>
            <button id="subtask-${task.number}-2" class="subtask-button ${task.subtasks[2] ? 'completed' : ''}" onclick="completeSubtask(${task.number}, 2)">
                ${task.subtasks[2] ? 'Subtask 3 Completed' : 'Mark Subtask 3 as Done'}
            </button>
            <button class="delete-task-button" onclick="deleteTask(${task.number})">Delete Task</button>
        `;
        taskDetailsContainer.appendChild(taskDetails);
    }


    // Function to mark a task as done
    function markTaskAsDone(taskNumber) {
        const task = projectData[currentProject].tasks.find(t => t.number === taskNumber);
        task.done = true; // Mark task as done

        updateProjectProgress(); // Update overall project progress
    }

    // Function to unmark a task as done
    function unmarkTaskAsDone(taskNumber) {
        const task = projectData[currentProject].tasks.find(t => t.number === taskNumber);
        task.done = false; // Unmark task as done

        updateProjectProgress(); // Update overall project progress
    }

    // Function to complete a subtask and update mini progress bar
    function completeSubtask(taskNumber, subtaskIndex) {
        const task = projectData[currentProject].tasks.find(t => t.number === taskNumber);
        task.subtasks[subtaskIndex] = !task.subtasks[subtaskIndex]; // Toggle subtask state

        const subtaskButton = document.querySelector(`#subtask-${taskNumber}-${subtaskIndex}`);

        // Toggle the class based on whether the subtask is completed
        if (task.subtasks[subtaskIndex]) {
            subtaskButton.classList.add('completed'); // Add the green background
            subtaskButton.textContent = `Subtask ${subtaskIndex + 1} Completed`;
        } else {
            subtaskButton.classList.remove('completed'); // Revert to blue background
            subtaskButton.textContent = `Mark Subtask ${subtaskIndex + 1} as Done`;
        }

        // Update the mini progress bar for the task
        document.getElementById(`mini-progress-${taskNumber}`).style.width = calculateMiniProgress(task) + '%';
    
        // If all subtasks are done, mark the task as done, else unmark
        if (task.subtasks.every(Boolean)) {
            markTaskAsDone(taskNumber);
        } else {
            unmarkTaskAsDone(taskNumber);
        }

        showTask(taskNumber); // Re-render the task to update subtask buttons
    }

    // Function to calculate mini progress for a task
    function calculateMiniProgress(task) {
        const completedSubtasks = task.subtasks.filter(Boolean).length;
        return (completedSubtasks / task.subtasks.length) * 100;
    }

    // Function to update overall project progress
    function updateProjectProgress() {
        const projectTasks = projectData[currentProject].tasks;
        const completedTasks = projectTasks.filter(task => task.subtasks.every(Boolean)).length;
        const progress = (completedTasks / projectTasks.length) * 100;
        projectData[currentProject].progress = progress;

        document.getElementById('progress-bar').style.width = progress + '%';
        document.getElementById('progress-text').textContent = `Progress: ${progress}%`;
    }

    // Function to add a new task to the current project
    function addTask() {
        const taskList = projectData[currentProject].tasks;
        const newTaskNumber = taskCounter[currentProject]++;
        const newTask = {
            number: newTaskNumber,
            name: `New Task #${newTaskNumber}`,
            subtasks: [false, false, false],
            done: false
        };
        taskList.push(newTask); // Add the new task to the current project's task list
        dynamicDisplay(currentProject); // Re-render the task list
        updateProjectProgress(); // Update the project progress
    }

    // Function to delete a specific task from the current project
    function deleteTask(taskNumber) {
        projectData[currentProject].tasks = projectData[currentProject].tasks.filter(t => t.number !== taskNumber);
        dynamicDisplay(currentProject); // Re-render the task list
        updateProjectProgress(); // Update the project progress
        document.getElementById('task-details-container').innerHTML = ''; // Clear task details
    }

    // Initially load Project 1
    switchProject(1);
</script>

</body>
</html>
