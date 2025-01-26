<?php
session_start();
include("connection.php");
include("functions.php");
check_login($con);

// Delete trainer if delete button is clicked
if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete trainer from the database
    $delete_query = "DELETE FROM trainers WHERE id = '$delete_id'";
    if(mysqli_query($con, $delete_query)) {
        echo "Trainer deleted successfully.";
    } else {
        echo "Error deleting trainer: " . mysqli_error($con);
    }
}

// Fetch trainers from the database
$query = "SELECT * FROM trainers";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Trainers</title>
    <!-- CSS styles -->
	<style>
	body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

h2 {
    text-align: center;
    margin-top: 20px;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
}

th, td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
}

th {
    background-color: #333;
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

    a {
            text-decoration: none;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .edit-link {
            background-color: #28a745;
        }

        .delete-link {
            background-color: #dc3545;
        }
</style>
	
</head>
<body>
    <h2>Trainers</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Father/Husband Name</th>
            <th>Gender</th>
            <th>Address</th>
            <th>City</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['father_husband_name']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="update_trainer.php?id=<?php echo $row['id']; ?>">Update</a>
                    <a href="viewtrainers.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this trainer?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
