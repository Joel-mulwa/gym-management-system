<?php
session_start();

// Your database connection details
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

// Check if the customer is logged in
if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    // Fetch booking list for the logged-in customer
    $query_booking_list = "SELECT b.booking_id, b.schedule, b.plan_id, p.plan_type, b.package_id, pa.name AS package_name, pa.description AS package_description, pa.amount, b.status 
                          FROM bookings b
                          JOIN plans p ON b.plan_id = p.plan_id
                          JOIN packages pa ON b.package_id = pa.package_id
                          WHERE b.customer_id = $customerId";
    $result_booking_list = mysqli_query($con, $query_booking_list);
} else {
    // Customer not logged in, handle this case as needed
    $result_booking_list = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>
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
    </style>
</head>
<body>
    <h1>Booking List</h1>

    <?php if ($result_booking_list) { ?>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Schedule</th>
                <th>Plan Type</th>
                <th>Package Name</th>
                <th>Package Description</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            <?php while ($row_booking = mysqli_fetch_assoc($result_booking_list)) { ?>
                <tr>
                    <td><?php echo $row_booking['booking_id']; ?></td>
                    <td><?php echo $row_booking['schedule']; ?></td>
                    <td><?php echo $row_booking['plan_type']; ?></td>
                    <td><?php echo $row_booking['package_name']; ?></td>
                    <td><?php echo $row_booking['package_description']; ?></td>
                    <td><?php echo $row_booking['amount']; ?></td>
                    <td><?php echo $row_booking['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No bookings found for the logged-in customer.</p>
    <?php } ?>

</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
