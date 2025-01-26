<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_time_24 = $_POST['start-time']; // Get start time in 24-hour format from the form
    $end_time_24 = $_POST['end-time']; // Get end time in 24-hour format from the form

    // Check if both times are provided
    if (empty($start_time_24) || empty($end_time_24)) {
        echo "Please enter both start time and end time.";
        return;
    }

    // Convert 24-hour format to 12-hour format
    $start_time = date("h:i A", strtotime($start_time_24));
    $end_time = date("h:i A", strtotime($end_time_24));

    // Combine start and end time into a single string
    $time_range = $start_time . " - " . $end_time;

    $sql = "INSERT INTO timeslots (time_range) VALUES ('$time_range')";

    if (mysqli_query($con, $sql)) {
        echo "Timeslot added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Timeslot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .container {
            display: flex;
            height: calc(100vh - 40px); /* subtract header height */
        }
        
        .content {
            flex: 1;
            padding: 20px;
            text-align: center;
        }
        .form-container {
            width: 50%;
            margin: auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container label {
            display: block;
            margin-bottom: 10px;
        }
        .form-container input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-container button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-sizing: border-box;
            transition: background-color 0.3s;
        }
        .form-container button[type="submit"]:hover {
            background-color: #555;
        }
        .form-container button[type="button"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #444;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-sizing: border-box;
            transition: background-color 0.3s;
        }
        .form-container button[type="button"]:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="form-container">
                <h3>Enter Timeslot</h3>
                <form id="timeslotForm" method="POST" action="process_form.php">
                    <label for="start-time">Start Time:</label>
                    <input type="time" id="start-time" name="start-time" required>
                    <label for="end-time">End Time:</label>
                    <input type="time" id="end-time" name="end-time" required>
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
