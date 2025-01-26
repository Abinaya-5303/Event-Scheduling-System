<?php
include 'connection.php'; // Include your database connection file

// Check if the form is submitted for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $days = mysqli_real_escape_string($con, $_POST['days']);
    $fees = mysqli_real_escape_string($con, $_POST['fees']);

    // Update the data in the database
    $update_query = "UPDATE workshop_class SET name = '$name', type = '$type', days = '$days', fees = '$fees' WHERE id = '$id'";
    if (mysqli_query($con, $update_query)) {
        header("Location: viewworcls.php"); // Redirect to the main view page
        exit();
    } else {
        echo "ERROR: Could not execute $update_query. " . mysqli_error($con);
    }
}

// Retrieve the existing data to pre-fill the form
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $select_query = "SELECT * FROM workshop_class WHERE id = '$id'";
    $result = mysqli_query($con, $select_query);
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Workshop/Class Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            width: 50%;
            margin: auto;
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
        .form-container input[type="submit"] {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049; /* Darker green */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update Workshop or Class Details</h2>
        <form action="update_form.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            <label for="type">Options:</label>
            <select id="type" name="type" required>
                <option value="workshop" <?php if ($row['type'] == 'workshop') echo 'selected'; ?>>Workshop</option>
                <option value="class" <?php if ($row['type'] == 'class') echo 'selected'; ?>>Class</option>
            </select>
            <label for="days">Number of Days:</label>
            <input type="text" id="days" name="days" value="<?php echo $row['days']; ?>" required>
            <label for="fees">Fees (in Rupees):</label>
            <input type="text" id="fees" name="fees" value="<?php echo $row['fees']; ?>" required>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
