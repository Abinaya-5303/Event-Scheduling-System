<?php
session_start();
include("connection.php");
include("functions.php");
check_login($con);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $father_husband_name = mysqli_real_escape_string($con, $_POST['father_husband_name']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Insert the data into the database
    $query = "INSERT INTO trainers (name, father_husband_name, gender, address, city, phone, email) VALUES ('$name', '$father_husband_name', '$gender', '$address', '$city', '$phone', '$email')";

    if (mysqli_query($con, $query)) {
        // Redirect back to trainer.php with success message
        header("Location: trainer.php?success=true");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}

// Close the connection
mysqli_close($con);
?>
