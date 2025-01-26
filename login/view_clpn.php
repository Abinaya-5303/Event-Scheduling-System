<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

include 'connection.php';

// Fetch saved events from the database
$query = "SELECT * FROM events";
$result = mysqli_query($con, $query);
$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

function getEventStatus($startingDate, $endingDate) {
    $currentDate = date('Y-m-d');
    if ($currentDate > $endingDate) {
        return 'Completed';
    } elseif ($currentDate >= $startingDate && $currentDate <= $endingDate) {
        return 'Ongoing';
    } else {
        return 'Scheduled';
    }
}

function getCertificateIssueDate($endingDate) {
    return date('Y-m-d', strtotime($endingDate . ' + 8 days'));
}

function getGroupDeletionDate($endingDate) {
    return date('Y-m-d', strtotime($endingDate . ' + 6 months'));
}

function getGroupDeletionStatus($groupDeletionDate) {
    $currentDate = date('Y-m-d');
    if ($currentDate <= $groupDeletionDate) {
        return 'Active';
    } else {
        // Calculate the number of days past the group deletion date
        $daysPast = floor((strtotime($currentDate) - strtotime($groupDeletionDate)) / (60 * 60 * 24));
        return $daysPast; // Returning the number of days past
    }
}

function getStatusClass($status) {
    switch ($status) {
        case 'Completed':
            return 'status-completed';
        case 'Ongoing':
            return 'status-ongoing';
        case 'Scheduled':
            return 'status-scheduled';
        default:
            return '';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Events</title>
   <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 12px;
        }

        th, td {
            padding: 5px;
            text-align: left;
            border: 1px solid #333;
        }

        th {
            background-color: #40385A;
            color: white;
            white-space: nowrap;
        }

        td {
            white-space: nowrap;
        }

        .status-ongoing {
            background-color: #90ee90; /* Light green */
            color: black;
        }

        .status-completed {
            background-color: #f8d7da; /* Light red */
            color: black;
        }

        .status-scheduled {
            background-color: #fffacd; /* Light yellow */
            color: black;
        }

        .status-ongoing td.status-ongoing {
            background-color: #006400; /* Dark green */
            color: white;
        }

        .status-completed td.status-completed {
            background-color: #8b0000; /* Dark red */
            color: white;
        }

        .status-scheduled td.status-scheduled {
            background-color: #ffd700; /* Dark yellow */
            color: black;
        }

        /* Style for the delete button */
        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style for the checkbox */
        input[type="checkbox"] {
            transform: scale(1.5); /* Make checkbox larger */
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h2>View Events</h2>
	 <form method="post" action="delete_events.php"> <!-- Form for deleting events -->
       
    <table>
        <thead>
            <tr >
				<th>Serial No</th> <!-- New column for serial number -->
                <th>Event Name</th>
                <th>Trainer Name</th>
                <th>Tentative Date</th>
                <th>Finalised Date</th>
                <th>Starting Date</th>
                <th>Starting Day</th>
                <th>Number of Days</th>
                <th>Days Option</th>
                <th>Ending Date</th>
                <th>Ending Day</th>
                <th>Timeslot</th>
                <th>Duration Hours</th>
                <th>Total Duration Hours</th>
                <th>Fees</th>
                <th>Event Status</th>
				
                <th>Certificate Issue Date</th>
                <th>Group Deletion Date</th>
                <th>Group Deletion Status</th> <!-- New column -->
				<th>Delete</th>
            </tr>
</tr>
        </thead>
        <tbody>
            <?php if (count($events) > 0): ?>
			 <?php $serial = 1; ?> <!-- Initialize serial number counter -->
                <?php foreach ($events as $event): ?>
                    <?php
                    $status = getEventStatus($event['starting_date'], $event['ending_date']);
                    $statusClass = getStatusClass($status);
                    $certificateIssueDate = getCertificateIssueDate($event['ending_date']);
                    $groupDeletionDate = getGroupDeletionDate($event['ending_date']);
                    $groupDeletionStatus = getGroupDeletionStatus($groupDeletionDate);
                    ?>
                    <tr class="<?php echo $statusClass; ?>">
						 <td><?php echo $serial; ?></td> <!-- Display serial number -->
                        <td><?php echo $event['event_name']; ?></td>
                        <td><?php echo $event['trainer_name']; ?></td>
                        <td><?php echo $event['tentative_date']; ?></td>
                        <td><?php echo $event['finalised_date']; ?></td>
                        <td><?php echo $event['starting_date']; ?></td>
                        <td><?php echo $event['starting_day']; ?></td>
                        <td><?php echo $event['number_of_days']; ?></td>
                        <td><?php echo $event['days_option']; ?></td>
                        <td><?php echo $event['ending_date']; ?></td>
                        <td><?php echo $event['ending_day']; ?></td>
                        <td><?php echo $event['timeslot']; ?></td>
                        <td><?php echo $event['duration_hours']; ?></td>
                        <td><?php echo $event['total_duration_hours']; ?></td>
                        <td><?php echo $event['fees']; ?></td>
                        <td class="<?php echo $statusClass; ?>"><?php echo $status; ?></td>
                        <td><?php echo $certificateIssueDate; ?></td>
                        <td><?php echo $groupDeletionDate; ?></td>
                        <td><?php echo ($groupDeletionStatus == 'Active') ? 'Active' : 'Notified ' . $groupDeletionStatus; ?></td> <!-- Display group deletion status -->
						<td><input type="checkbox" name="delete[]" value="<?php echo $event['id']; ?>"></td> <!-- Checkbox for deletion -->
						<?php $serial++; ?> <!-- Increment serial number -->
					</tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="18">No events found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
	<button type="submit">Delete Selected Events</button> <!-- Button to trigger deletion -->
</body>
</html>
