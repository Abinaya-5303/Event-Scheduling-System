<?php
session_start();
include("connection.php");
include("functions.php");
check_login($con);

// Check if trainer ID is provided
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $trainer_id = $_GET['id'];

    // Fetch trainer details from the database
    $query = "SELECT * FROM trainers WHERE id = '$trainer_id'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $father_husband_name = $row['father_husband_name'];
        $gender = $row['gender'];
        $address = $row['address'];
        $city = $row['city'];
        $phone = $row['phone'];
        $email = $row['email'];
    } else {
        echo "Invalid trainer ID.";
        exit();
    }
} else {
    echo "Invalid trainer ID.";
    exit();
}

// If form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $father_husband_name = mysqli_real_escape_string($con, $_POST['father_husband_name']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Update trainer details in the database
    $update_query = "UPDATE trainers SET name='$name', father_husband_name='$father_husband_name', gender='$gender', address='$address', city='$city', phone='$phone', email='$email' WHERE id='$trainer_id'";
    if(mysqli_query($con, $update_query)) {
        // Redirect back to viewtrainers.php after update
        header("Location: viewtrainers.php");
        exit();
    } else {
        echo "Error updating trainer details: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Trainer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Trainer</h2>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

            <label for="father_husband_name">Father/Husband Name:</label>
            <input type="text" id="father_husband_name" name="father_husband_name" value="<?php echo $father_husband_name; ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if($gender == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($gender == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($gender == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $city; ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
