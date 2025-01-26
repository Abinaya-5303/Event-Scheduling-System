<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete timeslot
    $sql = "DELETE FROM time_slots WHERE id = $id";

    if (mysqli_query($con, $sql)) {
        echo "Timeslot deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    // Redirect back to viewtimeslots.php
    header("Location: viewtimeslots.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
