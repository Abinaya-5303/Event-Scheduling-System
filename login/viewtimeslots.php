<?php
include 'connection.php';

// Check if delete action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_delete = "DELETE FROM timeslots WHERE id = $id";
    if (mysqli_query($con, $sql_delete)) {
        echo '<script>alert("Time slot deleted successfully!");</script>';
    } else {
        echo '<script>alert("Error deleting time slot.");</script>';
    }
}

$sql = "SELECT * FROM timeslots";
$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Time Slots</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            justify-content: space-around;
        }

        .edit-btn, .delete-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Time Slots</h2>
        <table>
            <thead>
                <tr>
                   
                    <th>Time Range</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        
                        echo "<td>" . $row['time_range'] . "</td>";
                        echo "<td class='actions'>";
                        echo "<a class='edit-btn' href='edit_timeslot.php?id=" . $row['id'] . "'>Edit</a>";
                        echo "<a class='delete-btn' href='viewtimeslots.php?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this time slot?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No time slots available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
