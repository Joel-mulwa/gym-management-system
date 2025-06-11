<?php
session_start();

// Database connection details
$host = "localhost";
$username_db = "root";
$password_db = "";
$database = "thegymdb";

// Establish database connection
$con = mysqli_connect($host, $username_db, $password_db, $database);

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$query_booking_list = "SELECT b.booking_id, b.schedule, b.plan_id, p.plan_type, b.package_id, pkg.name as package_name, pkg.description as package_description, pkg.amount as package_amount, b.status
                      FROM bookings b
                      JOIN plans p ON b.plan_id = p.plan_id
                      JOIN packages pkg ON b.package_id = pkg.package_id";
                     

$result_booking_list = mysqli_query($con, $query_booking_list);

// Check for errors in the query execution
if (!$result_booking_list) {
    die("Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
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
            background-color: #4caf50;
            color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button {
            padding: 8px;
            cursor: pointer;
        }

        .approve-button {
            background-color: #4caf50;
            color: white;
        }

        .decline-button {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <h1>View Bookings</h1>

    <table>
        <tr>
            <th>Booking ID</th>
            <th>Schedule</th>
            <th>Plan Type</th>
            <th>Package Name</th>
            <th>Package Description</th>
            <th>Package Amount</th>
            <th>Status</th>
            
            <th>Action</th>
        </tr>
        <?php while ($row_booking = mysqli_fetch_assoc($result_booking_list)) { ?>
            <tr>
                <td><?php echo $row_booking['booking_id']; ?></td>
                <td><?php echo $row_booking['schedule']; ?></td>
                <td><?php echo $row_booking['plan_type']; ?></td>
                <td><?php echo $row_booking['package_name']; ?></td>
                <td><?php echo $row_booking['package_description']; ?></td>
                <td><?php echo $row_booking['package_amount']; ?></td>
                <td><?php echo $row_booking['status']; ?></td>
                
                <td class="action-buttons">
                <?php if ($row_booking['status'] === 'pending') { ?>
                    <button class="approve-button" onclick="takeAction(<?php echo $row_booking['booking_id']; ?>, 'approved')">Approve</button>
                    <button class="decline-button" onclick="takeAction(<?php echo $row_booking['booking_id']; ?>, 'declined')">Decline</button>
                <?php } elseif ($row_booking['status'] === 'approved') { ?>
                    <span>Approved</span>
                <?php } elseif ($row_booking['status'] === 'declined') { ?>
                    <span>Declined</span>
                <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <script>
        function takeAction(bookingId, action) {
            fetch('process_booking_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ booking_id: bookingId, action: action }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to take action');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Refresh the page or update the UI as needed
                    location.reload();
                } else {
                    alert('Failed to take action: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Failed to take action: ' + error.message);
            });
        }
    </script>
</body>
</html>
