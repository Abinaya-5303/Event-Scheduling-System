<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit; // Terminate script execution
}

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Check if at least one event ID is selected for deletion
    if (!empty($_POST['delete'])) {
        $ids = $_POST['delete']; // Array of event IDs to be deleted

        // Convert array of IDs to comma-separated string for SQL query
        $id_list = implode(',', array_map('intval', $ids));

        // SQL query to delete events with selected IDs
        $query = "DELETE FROM events WHERE id IN ($id_list)";

        // Execute the query
        if (mysqli_query($con, $query)) {
            // Redirect back to the page displaying events
            header("Location:view_clpn.php");
            exit; // Terminate script execution after redirect
        } else {
            // Error handling if the query fails
            echo "Error deleting events: " . mysqli_error($con);
        }
    } else {
        // If no event IDs are selected for deletion, display a message
        echo "Please select at least one event to delete.";
    }
} else {
    // If the form is not submitted via POST method, redirect to view_events.php
    header("Location:view_clpn.php");
    exit; // Terminate script execution after redirect
}
?>
