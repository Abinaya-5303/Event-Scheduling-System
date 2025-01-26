<?php
include 'connection.php';

// Initialize $message variable
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $days = mysqli_real_escape_string($con, $_POST['days']);
    $fees = mysqli_real_escape_string($con, $_POST['fees']); // New line for fees

    // Attempt to insert data into the database
    $sql = "INSERT INTO workshop_class (name, type, days, fees) VALUES ('$name', '$type', '$days', '$fees')"; // Updated SQL query

    if (mysqli_query($con, $sql)) {
        // Set success message
        $message = "Records added successfully.";
    } else {
        $message = "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
}

// Close connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop/Class Form</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 50%;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="rgba(0,0,0,0.54)" d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 12px 12px;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container p {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <h2>Enter Workshop or Class Details</h2>
        <form action="submit_form.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="type">Options:</label>
            <select id="type" name="type" required>
                <option value="workshop">Workshop</option>
                <option value="class">Class</option>
            </select>
            <label for="days">Number of Days:</label>
            <input type="text" id="days" name="days" required>
            <label for="fees">Fees in Rupees:</label> <!-- New label for fees -->
            <input type="text" id="fees" name="fees" required> <!-- New input field for fees -->
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
