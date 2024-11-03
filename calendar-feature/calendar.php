<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- ensure compatibility w/ older version of Internet Explorer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- makes pg responsive, adjust its width based on device's secreen size -->
    <title>CRM Dashboard (404)</title> <!-- our title -->
    <link rel="stylesheet" href="calendar.css"> <!-- Link to external CSS file -->
</head>
<body>
    <?php include '../sidebar.php'; ?>
    <div class="main-container">
    <header>
        <div class='image-header'>
            <a href="#" onclick="viewEventRedirect()">
                <img src="../img/megaphone-activity-events-icon.png" alt="View Event">
            </a>
        </div> 
        <button id="prev-month">Prev</button>
        <div class="current-date">
            <h1 class="month" id="month">October 2024</h1>
            <?php date_default_timezone_set('America/New_York');
            $currentDate = date("F j, Y"); 
            echo "<h1>Today's Date: $currentDate</h1>";?>
        </div>
        <button id="next-month">Next</button>
        <div class='image-header'>
            <a href="addevent.html">
                <img src="../img/add icon.png" alt="Add Note">
            </a>
        </div> 
    </header>
    <div>
        <input type="date" id="select-date">
        <button id="set-date">Set Date</button>
        <script src='calendar.js'></script>
    </div>
    <div class="calendar">
        <div class="days-row">
            <div class="day">Sunday</div>
            <div class="day-abbr">Su</div>
            <div class="day">Monday</div>
            <div class="day-abbr">M</div>
            <div class="day">Tuesday</div>
            <div class="day-abbr">Tu</div>
            <div class="day">Wednesday</div>
            <div class="day-abbr">W</div>
            <div class="day">Thursday</div>
            <div class="day-abbr">Th</div>
            <div class="day">Friday</div>
            <div class="day-abbr">F</div>
            <div class="day">Saturday</div>
            <div class="day-abbr">Sa</div>
        </div>
        <div class="calendar-grid" id="calendar-grid">
            <div class="day-box">29</div>
            <div class="day-box">30</div>
            <div class="day-box">1</div>
            <div class="day-box">2</div>
            <div class="day-box">3</div>
            <div class="day-box">4</div>
            <div class="day-box">5</div>
            <div class="day-box">6</div>
            <div class="day-box">7</div>
            <div class="day-box">8</div>
            <div class="day-box">9</div>
            <div class="day-box">10</div>
            <div class="day-box">11</div>
            <div class="day-box">12</div>
            <div class="day-box">13</div>
            <div class="day-box">14</div>
            <div class="day-box">15</div>
            <div class="day-box">16</div>
            <div class="day-box">17</div>
            <div class="day-box">18</div>
            <div class="day-box">19</div>
            <div class="day-box">20</div>
            <div class="day-box">21</div>
            <div class="day-box">22</div>
            <div class="day-box">23</div>
            <div class="day-box">24</div>
            <div class="day-box">25</div>
            <div class="day-box">26</div>
            <div class="day-box">27</div>
            <div class="day-box">28</div>
            <div class="day-box">29</div>
            <div class="day-box">30</div>
            <div class="day-box">31</div>
            <div class="day-box">1</div>
            <div class="day-box">2</div>
        </div>
    </div>
</div>
<div id='event-modal'>
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p id="popup-content"></p>
    </div>
</div>
<script src='calendar.js'></script>
</body>
</html>
