<?php
include 'connection.php';

// Check if form is submitted for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
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

    $sql_update = "UPDATE timeslots SET time_range = '$time_range' WHERE id = $id";

    if (mysqli_query($con, $sql_update)) {
        echo '<script>alert("Time slot updated successfully!");</script>';
        header("Location: viewtimeslots.php"); // Redirect to view time slots page after update
        exit();
    } else {
        echo '<script>alert("Error updating time slot.");</script>';
    }
}

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch time slot details based on ID
    $sql_select = "SELECT * FROM timeslots WHERE id = $id";
    $result = mysqli_query($con, $sql_select);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Time Slot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="time"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"], a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover, a:hover {
            background-color: #555;
        }

        a {
            margin-left: 10px;
            background-color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Time Slot</h2>
        <form id="editTimeslotForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="start-time">Start Time:</label>
            <input type="time" id="start-time" name="start-time" value="<?php echo date('H:i', strtotime(explode(' - ', $row['time_range'])[0])); ?>" required>
            <label for="end-time">End Time:</label>
            <input type="time" id="end-time" name="end-time" value="<?php echo date('H:i', strtotime(explode(' - ', $row['time_range'])[1])); ?>" required>
            <button type="submit" name="submit">Update</button>
            <a href="viewtimeslots.php">Cancel</a>
        </form>
    </div>
</body>
</html>
