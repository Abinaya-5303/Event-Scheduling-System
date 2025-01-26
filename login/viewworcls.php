<?php
include 'connection.php'; // Include your database connection file

// Check if delete action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $delete_query = "DELETE FROM workshop_class WHERE id = '$id'";
    if (mysqli_query($con, $delete_query)) {
        echo '<script>alert("Entry deleted successfully!");</script>';
    } else {
        echo '<script>alert("Error deleting entry.");</script>';
    }
}

// Retrieve workshop data
$workshop_query = "SELECT * FROM workshop_class WHERE type = 'workshop'";
$workshop_result = mysqli_query($con, $workshop_query);
if (!$workshop_result) {
    die("Error retrieving workshop data: " . mysqli_error($con));
}

// Retrieve class data
$class_query = "SELECT * FROM workshop_class WHERE type = 'class'";
$class_result = mysqli_query($con, $class_query);
if (!$class_result) {
    die("Error retrieving class data: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workshop and Class Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions a, .actions form input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .actions a:hover, .actions form input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2>Workshop Data</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Number of Days</th>
            <th>Fees (in Rupees)</th> <!-- Added fees column -->
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($workshop_result)) : ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['days']; ?></td>
                <td><?php echo $row['fees']; ?></td> <!-- Display fees -->
                <td>
                    <div class="actions">
                        <a href="update_form.php?id=<?php echo $row['id']; ?>">Update</a>
                        <a href="viewworcls.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Class Data</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Number of Days</th>
            <th>Fees (in Rupees)</th> <!-- Added fees column -->
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($class_result)) : ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['days']; ?></td>
                <td><?php echo $row['fees']; ?></td> <!-- Display fees -->
                <td>
                    <div class="actions">
                        <a href="update_form.php?id=<?php echo $row['id']; ?>">Update</a>
                        <a href="viewworcls.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
