<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

include 'connection.php';

// Fetch workshops and classes with their respective days and fees
$query = "SELECT name, type, days, fees FROM workshop_class";
$result = mysqli_query($con, $query);
$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

// Fetch time slots from the database
$sql = "SELECT * FROM timeslots";
$result = mysqli_query($con, $sql);
$timeSlots = array();
while ($row = mysqli_fetch_assoc($result)) {
    $timeSlots[] = $row;
}

// Fetch trainer names from the database
$sql = "SELECT name FROM trainers";
$result = mysqli_query($con, $sql);
$trainerNames = array();
while ($row = mysqli_fetch_assoc($result)) {
    $trainerNames[] = $row['name'];
}


/// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $event_name = $_POST['event_name'];
    $trainer_name = $_POST['trainer_name'];
    $tentative_date = $_POST['tentative_date'];
    $finalised_date = $_POST['finalised_date'];
    $starting_date = $_POST['starting_date'];
    $starting_day = $_POST['starting_day'];
    $number_of_days = $_POST['number_of_days'];
    $days_option = $_POST['days_option'];
    $ending_date = $_POST['ending_date'];
    $ending_day = $_POST['ending_day'];
    $timeslot_id = $_POST['timeslot'];
    $duration_hours = $_POST['duration_hours'];
    $total_duration_hours = $_POST['total_duration_hours'];
    $fees = $_POST['fees'];

    // Map days_option to readable format if needed
    $days_option_mapping = array(
        'off_sunday' => 'Off Sunday',
        'week_days_off' => 'Week Days Off',
        'week_days_on' => 'Week Days On'
    );

    if (array_key_exists($days_option, $days_option_mapping)) {
        $days_option = $days_option_mapping[$days_option];
    }

    // Fetch the time range for the selected timeslot ID
    $timeslot_query = "SELECT time_range FROM timeslots WHERE id = '$timeslot_id'";
    $timeslot_result = mysqli_query($con, $timeslot_query);
    if ($timeslot_row = mysqli_fetch_assoc($timeslot_result)) {
        $timeslot = $timeslot_row['time_range'];
    } else {
        $timeslot = ''; // Default value if no match found
    }

    // Insert data into database
    $sql = "INSERT INTO events (event_name, trainer_name, tentative_date, finalised_date, starting_date, starting_day, number_of_days, days_option, ending_date, ending_day, timeslot, duration_hours, total_duration_hours, fees) VALUES ('$event_name', '$trainer_name', '$tentative_date', '$finalised_date', '$starting_date', '$starting_day', '$number_of_days', '$days_option', '$ending_date', '$ending_day', '$timeslot', '$duration_hours', '$total_duration_hours', '$fees')";

    if (mysqli_query($con, $sql)) {
        echo "New event created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Planner</title>
     <style>
        /* Your existing CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .form-container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .form-column {
            width: calc(50% - 10px);
            margin-right: 10px;
        }

        .form-column:last-child {
            margin-right: 0;
        }

        .form-column div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select {
            background-color: #f9f9f9;
        }

        .submit-button {
            width: 100%;
            text-align: center;
        }

        button[type="submit"],
        button[type="button"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-sizing: border-box;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button[type="submit"]:hover,
        button[type="button"]:hover {
            background-color: #45a049;
        }

        /* Add CSS for the back to home button */
        .back-home-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .back-home-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ccc;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-home-button:hover {
            background-color: #999;
        }
    </style>
    <script>
    var events = <?php echo json_encode($events); ?>;
    var timeSlots = <?php echo json_encode($timeSlots); ?>;
    var trainerNames = <?php echo json_encode($trainerNames); ?>;

    function populateDays() {
        var eventName = document.getElementById('event_name').value;
        var daysInput = document.getElementById('number_of_days');

        for (var i = 0; i < events.length; i++) {
            if (events[i].name === eventName) {
                daysInput.value = events[i].days;
                calculateDates();
                break;
            }
        }
    }

    function calculateDuration() {
        var timeslotSelect = document.getElementById('timeslot');
        var selectedTimeslot = timeslotSelect.options[timeslotSelect.selectedIndex].text;

        var timeParts = selectedTimeslot.split(' - ');
        var startTime = timeParts[0];
        var endTime = timeParts[1];

        var start = new Date("01/01/2000 " + startTime);
        var end = new Date("01/01/2000 " + endTime);
        if (end < start) {
            end.setDate(end.getDate() + 1);
        }
        var duration = (end - start) / (1000 * 60 * 60);

        var numberOfDays = parseInt(document.getElementById('number_of_days').value);
        var totalDuration = duration * numberOfDays;

        document.getElementById('duration_hours').value = duration;
        document.getElementById('total_duration_hours').value = totalDuration.toFixed(2);
    }

    function populateFees() {
        var eventName = document.getElementById('event_name').value;
        var feesInput = document.getElementById('fees');

        for (var i = 0; i < events.length; i++) {
            if (events[i].name === eventName) {
                feesInput.value = events[i].fees;
                break;
            }
        }
    }

function calculateDates() {
    var tentativeDate = new Date(document.getElementById('tentative_date').value);
    var finalisedDateInput = document.getElementById('finalised_date');
    var startingDateInput = document.getElementById('starting_date');
    var startingDayInput = document.getElementById('starting_day');

    // Set finalised date to tentative date
    finalisedDateInput.value = tentativeDate.toISOString().slice(0, 10);

    // Set starting date to tentative date
    startingDateInput.value = tentativeDate.toISOString().slice(0, 10);

    // Set starting day
    startingDayInput.value = getDayName(tentativeDate);

    // Automatically update ending date and day
    calculateEndingDate();
}

function calculateEndingDate() {
    var startingDate = new Date(document.getElementById('starting_date').value);
    var numberOfDays = parseInt(document.getElementById('number_of_days').value);
    var daysOption = document.getElementById('days_option').value;

    var currentDay = new Date(startingDate); // Create a new date object to avoid modifying the original

    var daysCounted = 0;
    while (daysCounted < numberOfDays) {
        if (daysOption === 'week_days_off' && (currentDay.getDay() === 6 || currentDay.getDay() === 0)) {
            // Skip Saturday and Sunday
        } else if (daysOption === 'off_sunday' && currentDay.getDay() === 0) {
            // Skip Sunday
        } else {
            daysCounted++;
        }
        if (daysCounted < numberOfDays) {
            currentDay.setDate(currentDay.getDate() + 1);
        }
    }

    var endingDateInput = document.getElementById('ending_date');
    var endingDayInput = document.getElementById('ending_day');
    endingDateInput.value = currentDay.toISOString().slice(0, 10);
    endingDayInput.value = getDayName(currentDay);
}

function getDayName(date) {
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    return days[date.getDay()];
}

// Event listeners
window.onload = function() {
    document.getElementById('tentative_date').addEventListener('change', calculateDates);
    document.getElementById('starting_date').addEventListener('change', calculateEndingDate);
    document.getElementById('number_of_days').addEventListener('input', calculateEndingDate);
    document.getElementById('days_option').addEventListener('change', calculateEndingDate);
	  document.getElementById('event_name').addEventListener('change', populateFees);
        document.getElementById('timeslot').addEventListener('change', calculateDuration);
        document.getElementById('event_name').addEventListener('change', populateDays);
};


    </script>
</head>
<body>
 
    <h2>Event Planner</h2>
    <form action="submit_event.php" method="post" id="eventForm">
        <div class="back-home-container">
            <a href="index.php" class="back-home-button">Back to Home</a>
        </div>
        <div class="form-container">
            <div class="form-column">
                <div>
				
                    <label for="event_name">Event Name:</label>
                    <select id="event_name" name="event_name" onchange="populateDays()" required>
                        <option value="" disabled selected>Select Event Name</option>
                        <optgroup label="Workshop">
                            <?php foreach ($events as $event): ?>
                                <?php if ($event['type'] == 'workshop'): ?>
                                    <option value="<?php echo $event['name']; ?>"><?php echo $event['name']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="Class">
                            <?php foreach ($events as $event): ?>
                                <?php if ($event['type'] == 'class'): ?>
                                    <option value="<?php echo $event['name']; ?>"><?php echo $event['name']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label for="trainer_name">Trainer Name:</label>
                    <select id="trainer_name" name="trainer_name" required>
                        <option value="" disabled selected>Select Trainer Name</option>
                        <?php foreach ($trainerNames as $name): ?>
                            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="tentative_date">Tentative Date:</label>
                    <input type="date" id="tentative_date" name="tentative_date" required>
				</div>
				<div>
                    <label for="finalised_date">Finalised Date:</label>
                    <input type="date" id="finalised_date" name="finalised_date" required>
				</div>
				<div>
                    <label for="starting_date">Starting Date:</label>
                    <input type="date" id="starting_date" name="starting_date" required>
				</div>
				<div>
                    <label for="starting_day">Starting Day:</label>
                    <input type="text" id="starting_day" name="starting_day" readonly>
                </div>
                <div>
                    <label for="number_of_days">Number of Days:</label>
                    <input type="text" id="number_of_days" name="number_of_days" readonly required>
                </div>
            </div>
            <div class="form-column">
                <div>
    <label for="days_option">Days option:</label>
    <select id="days_option" name="days_option" onchange="calculateEndingDate()" required>
        <option value="" disabled selected>Select Day Option</option>
        <option value="off_sunday">Off Sunday</option>
        <option value="week_days_off">Week Days Off</option>
        <option value="week_days_on">Week Days On</option>
    </select>
</div>

                <div>
                    <label for="ending_date">Ending Date:</label>
                    <input type="date" id="ending_date" name="ending_date" required>
                </div>
                <div>
                    <label for="ending_day">Ending Day:</label>
                    <input type="text" id="ending_day" name="ending_day" readonly>
                </div>
                <div>
                    <label for="timeslot">Timeslot:</label>
                    <select id="timeslot" name="timeslot" onchange="calculateDuration()" required>
                        <option value="" disabled selected>Select Timeslot</option>
                        <?php foreach ($timeSlots as $slot): ?>
                            <option value="<?php echo $slot['id']; ?>"><?php echo $slot['time_range']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="duration_hours">Duration in Hours:</label>
                    <input type="number" id="duration_hours" name="duration_hours" readonly required>
                </div>
                <div>
                    <label for="total_duration_hours">Total Duration (hours):</label>
                    <input type="text" id="total_duration_hours" name="total_duration_hours" readonly>
                </div>
                <div>
                    <label for="fees">Fees for Event (in Rupees):</label>
                    <input type="number" id="fees" name="fees" required>
                </div>
            </div>
            <div class="submit-button">
                <button type="submit">Submit</button>
            </div>
        </div>
    </form>
</body>
</html>
