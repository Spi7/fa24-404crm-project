<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="dashboard.js" defer></script>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar">
        <h1>Client Dashboard</h1>
        <ul>
            <li><a href="../home-page/home.php">Home</a></li>
            <li><a href="../calendar-feature/calendar.php">Calendar</a></li>
            <li><a href="../projects-feature/project.php">Projects</a></li>
            <li><a href="../invoice-feature/invoice.php">Invoices</a></li>
            <li><a href="../chat-feature/chat.php">Chat</a></li>
        </ul>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Client List Section -->
        <div class="client-list">
            <h2>Clients</h2>
            <!-- Client cards will be populated here dynamically -->
            <!-- Example Client Card -->
            <!-- Client Card 1 -->
            <div class="client-card" onclick="expandCard(this)">
                <h3>Client Name</h3>
                <p><strong>Goals:</strong> Improve marketing strategy, Increase revenue</p>
                <p><strong>Values:</strong> Customer satisfaction, Innovation</p>
                <div class="expanded-content">
                    <p><strong>Company Affiliation:</strong> Company A</p>
                    <p><strong>Invoice History:</strong> Last payment received in November 2024</p>
                    <p><strong>Other Details:</strong> Extra Details...</p>
                </div>
                <div class="actions">
                    <button onclick="window.location.href='../calendar-feature/myscheduler.html'">Schedule Meeting</button>
                    <button onclick="window.location.href='../invoice-feature/invoice.php'">Send Invoice</button>
                </div>
            </div>

            <div class="client-card" onclick="expandCard(this)">
                <h3>Client B</h3>
                <p><strong>Goals:</strong> Enhance product quality, Expand market reach</p>
                <p><strong>Values:</strong> Sustainability, Integrity</p>
                <div class="expanded-content">
                    <p><strong>Company Affiliation:</strong> Company A</p>
                    <p><strong>Invoice History:</strong> Last payment received in October 2024</p>
                    <p><strong>Other Details:</strong> Extra Details...</p>
                </div>
                <div class="actions">
                    <button onclick="window.location.href='../calendar-feature/myscheduler.html'">Schedule Meeting</button>
                    <button onclick="window.location.href='../invoice-feature/invoice.php'">Send Invoice</button>
                </div>
            </div>
            <!-- More client cards can go here -->
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchClients();
        });

        function fetchClients() {
            fetch('get-clients.php')
                .then(response => response.json())
                .then(data => {
                    const clientList = document.querySelector('.client-list');
                    clientList.innerHTML = ''; // Clear any existing content

                    if (data.status !== "success" || !Array.isArray(data.clients)) {
                        console.error("Expected an array but received:", data);
                        return;
                    }

                    data.clients.forEach(client => {
                        const clientCard = document.createElement('div');
                        clientCard.classList.add('client-card');

                        clientCard.innerHTML = `
                            <h3>${client.name}</h3>
                            <p><strong>Goals:</strong> ${client.goals}</p>
                            <p><strong>Values:</strong> ${client.values}</p>
                            <div class="actions">
                                <button onclick="window.location.href='#'">Schedule Meeting</button>
                                <button onclick="window.location.href='../invoice-feature/invoice.php?clientId=${client.user_id}'">Send Invoice</button>
                            </div>
                        `;
                        clientList.appendChild(clientCard);
                    });
                })
                .catch(error => console.error('Error fetching clients:', error));
        }   
    </script>

</body>
</html>
