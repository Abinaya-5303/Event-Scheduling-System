<?php
// events_template.php

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            border: 1px solid #333;
        }

        th {
            background-color: #40385A;
            color: white;
        }

        .status-ongoing {
            background-color: #90ee90; /* Light green */
        }

        .status-completed {
            background-color: #f8d7da; /* Light red */
        }

        .status-scheduled {
            background-color: #fffacd; /* Light yellow */
        }
    </style>
</head>
<body>
    <h2>View Events</h2>
    <table>
        <thead>
            <tr>
                <th>Serial No</th>
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
                <th>Group Deletion Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($events) > 0): ?>
                <?php $serial = 1; ?>
                <?php foreach ($events as $event): ?>
                    <?php
                    $status = getEventStatus($event['starting_date'], $event['ending_date']);
                    $statusClass = getStatusClass($status);
                    $certificateIssueDate = getCertificateIssueDate($event['ending_date']);
                    $groupDeletionDate = getGroupDeletionDate($event['ending_date']);
                    $groupDeletionStatus = getGroupDeletionStatus($groupDeletionDate);
                    ?>
                    <tr class="<?php echo $statusClass; ?>">
                        <td><?php echo $serial; ?></td>
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
                        <td><?php echo $status; ?></td>
                        <td><?php echo $certificateIssueDate; ?></td>
                        <td><?php echo $groupDeletionDate; ?></td>
                        <td><?php echo ($groupDeletionStatus == 'Active') ? 'Active' : 'Notified ' . $groupDeletionStatus; ?></td>
                    </tr>
                    <?php $serial++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="19">No events found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
