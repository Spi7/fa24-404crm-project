<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <link rel="stylesheet" href="project.css"> <!-- Link to the external CSS file -->
    <script>
        function loadMobileCSS() {
            if (window.innerWidth <= 600) {
                var mobileCss = document.createElement('link');
                mobileCss.rel = 'stylesheet';
                mobileCss.href = 'chat-mobile.css';
                document.head.appendChild(mobileCss);

                var sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.style.display = 'none';
                }
            }
        }
        window.onload = loadMobileCSS;
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

            <div class="progress-bar-container">
                <div class="progress-bar" id="progress-bar" style="width: 0%;"></div>
            </div>
            <span id="progress-text">Progress: 0%</span>

            <div class="project-switcher">
                <button onclick="switchProject(1)">Project #1</button>
                <button onclick="switchProject(2)">Project #2</button>
                <button onclick="switchProject(3)">Project #3</button>
            </div>

            <button class="add-task-button" onclick="addTask()">Add Task</button>
        </div>

        <ul class="task-list" id="task-list"></ul>
        <div id="task-details-container"></div>
    </div>
</div>

<script>
    let currentProject = 1;

    // Switch between projects and load project data
    function switchProject(projectNumber) {
        currentProject = projectNumber;
        loadProjectData(projectNumber);
    }

    // Load project data, including tasks and subtasks
    function loadProjectData(projectId) {
    fetch(`fetch_project_data.php?project_id=${projectId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Loaded Project Data:', data); // Debugging output
            if (data.error) {
                alert(data.error);
                return;
            }

            const { project, tasks } = data;
            document.getElementById('project-title').textContent = project.TITLE;
            document.getElementById('progress-bar').style.width = project.PROGRESS + '%';
            document.getElementById('progress-text').textContent = `Progress: ${project.PROGRESS}%`;

            const taskList = document.getElementById('task-list');
            taskList.innerHTML = '';
            tasks.forEach(task => {
                const taskItem = document.createElement('li');
                taskItem.textContent = `Task #${task.TASK_ID}: "${task.TITLE}"`;
                taskItem.onclick = () => showTask(task);
                taskList.appendChild(taskItem);
            });
        })
        .catch(error => console.error('Error fetching project data:', error));
}


    // Show task details and display subtasks
    function showTask(task) {
    const taskDetailsContainer = document.getElementById('task-details-container');
    taskDetailsContainer.innerHTML = '';

    const taskDetails = document.createElement('div');
    taskDetails.classList.add('task-details');
    taskDetails.innerHTML = `
        <h3>Task #${task.TASK_ID} Details</h3>
        <p>Task Description: "${task.TITLE}"</p>
        <div class="mini-progress-bar">
            <div class="mini-progress" id="mini-progress-${task.TASK_ID}" style="width: ${task.PROGRESS}%"></div>
        </div>
        <span class="mini-progress-percentage" id="progress-text-${task.TASK_ID}">Progress: ${task.PROGRESS}%</span>
    `;

    if (task.subtasks && task.subtasks.length > 0) {
        const subtaskList = document.createElement('ul');
        subtaskList.classList.add('subtask-list');

        task.subtasks.forEach((subtask, index) => {
            const subtaskItem = document.createElement('li');
            subtaskItem.classList.add('subtask-item');
            subtaskItem.innerHTML = `
                <span>${subtask.DESCRIPTION}</span>
                <button id="subtask-${task.TASK_ID}-${subtask.SUBTASK_ID}" 
                    class="subtask-button ${subtask.COMPLETED ? 'completed' : ''}" 
                    onclick="completeSubtask(${task.TASK_ID}, ${subtask.SUBTASK_ID})">
                    ${subtask.COMPLETED ? 'Subtask Completed' : 'Mark Subtask as Done'}
                </button>
            `;
            subtaskList.appendChild(subtaskItem);
        });

        taskDetails.appendChild(subtaskList);
    } else {
        taskDetails.innerHTML += `<p>No subtasks available for this task.</p>`;
    }

    taskDetails.innerHTML += `<button class="delete-task-button" onclick="deleteTask(${task.TASK_ID})">Delete Task</button>`;
    taskDetailsContainer.appendChild(taskDetails);
}

function completeSubtask(taskId, subtaskId, completed) {
    const subtaskButton = document.getElementById(`subtask-${taskId}-${subtaskId}`);
    
    // Toggle completion status based on button's current state
    if (subtaskButton.classList.contains('completed')) {
        completed = false; // Mark as not completed if it's currently completed
    } else {
        completed = true; // Otherwise, mark it as completed
    }

    // Fetch request to update the subtask progress
    fetch('update_subtask_progress.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ task_id: taskId, subtask_id: subtaskId, completed: completed ? 1 : 0 })
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response and update UI accordingly
        if (data.status === 'success') {
            // Update the UI based on the new completion status
            subtaskButton.classList.toggle('completed', completed);
            subtaskButton.textContent = completed ? 'Subtask Completed' : 'Mark Subtask as Done';

            // Update the mini progress bar for the specific task
            updateProgress(taskId, data.task_progress);

            // Update the total project progress after the mini progress is updated
            updateTotalProjectProgress();
        } else {
            console.error('Error updating subtask:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateProgress(taskId, taskProgress) {
    const miniProgressBar = document.getElementById(`mini-progress-${taskId}`);
    const progressTextElement = document.getElementById(`progress-text-${taskId}`);
    
    if (miniProgressBar) {
        miniProgressBar.style.width = `${taskProgress}%`;
    }
    
    if (progressTextElement) {
        progressTextElement.textContent = `Progress: ${taskProgress}%`;
    }
}

function updateTotalProjectProgress() {
    fetch(`calculate_project_progress.php?project_id=${currentProject}`)
        .then(response => response.json())
        .then(projectData => {
            if (projectData.status === 'success') {
                const totalProgressBar = document.getElementById('progress-bar');
                const totalProgressText = document.getElementById('progress-text');

                if (totalProgressBar && totalProgressText) {
                    totalProgressBar.style.width = `${projectData.project_progress}%`;
                    totalProgressText.textContent = `Progress: ${projectData.project_progress}%`;
                }
            } else {
                console.error('Error updating project progress:', projectData.message);
            }
        })
        .catch(error => console.error('Error fetching total project progress:', error));
}

    // Function to add a new task to the current project
    function addTask() {
        const taskTitle = prompt("Enter the task title:");
        if (!taskTitle) return; // Exit if title is not provided

        const taskDescription = prompt("Enter the task description:"); // New prompt for description
        if (!taskDescription) return; // Exit if description is not provided

        fetch('add_task.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `project_id=${currentProject}&title=${encodeURIComponent(taskTitle)}&description=${encodeURIComponent(taskDescription)}` // Include description
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                loadProjectData(currentProject); // Refresh to include the new task
                updateTotalProjectProgress();
            } else {
                alert("Error adding task.");
            }
        })
        .catch(error => console.error("Error adding task:", error));
    }

    // Function to delete a specific task from the current project
    function deleteTask(taskId) {
        if (confirm("Are you sure you want to delete this task?")) {
            fetch('delete_task.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `task_id=${taskId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    loadProjectData(currentProject); // Refresh after deletion
                    updateTotalProjectProgress();
                } else {
                    alert("Error deleting task: " + data.message);
                }
            })
            .catch(error => console.error('Error deleting task:', error));
        }
    }
    // Initially load the first project
    switchProject(1);
</script>


</body>
</html>
