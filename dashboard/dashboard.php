<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
<!--    <script src="dashboard.js" defer></script> -->
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
            <!-- Client cards will be populated here dynamically -->
        </div>
    </div>

    <!-- JavaScript to fetch and display client data -->
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
                            <h3>${client.company_name}</h3>
                            <p><strong>Goals:</strong> ${client.goals}</p>
                            <p><strong>Values:</strong> ${client.values}</p>
                            <div class="expanded-content">
                                <p><strong>Company Affiliation:</strong> ${client.affiliation}</p>
                                <p><strong>Invoice History:</strong> ${client.invoice_history}</p>
                                <p><strong>Other Details:</strong> ${client.notes}</p>
                            </div>
                            <div class="actions">
                                <button onclick="window.location.href='#'">Schedule Meeting</button>
                                <button onclick="window.location.href='../invoice-feature/invoice.php?clientId=${client.user_id}'">Send Invoice</button>
                            </div>
                        `;
                        // //Event listener to call expandCard when clicked
                        // clientCard.addEventListener('click', function() {
                        //     expandCard(clientCard);
                        // });

                        clientList.appendChild(clientCard);
                    });
                })
                .catch(error => console.error('Error fetching clients:', error));
        }   
    </script>

</body>
</html>