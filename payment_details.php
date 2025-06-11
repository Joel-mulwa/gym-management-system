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

// Fetch customer ID from the session
$customerId = $_SESSION['customer_id'];

// Fetch payment details for the logged-in customer
$query_payment_details = "SELECT * FROM payments WHERE customer_id = $customerId";
$result_payment_details = mysqli_query($con, $query_payment_details);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
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
    <h1>Payment Details</h1>

    <table>
        <tr>
            <th>Payment ID</th>
            <th>Customer ID</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Payment Date</th>
        </tr>
        <?php while ($row_payment = mysqli_fetch_assoc($result_payment_details)) { ?>
            <tr>
                <td><?php echo $row_payment['payment_id']; ?></td>
                <td><?php echo $row_payment['customer_id']; ?></td>
                <td><?php echo $row_payment['amount']; ?></td>
                <td><?php echo $row_payment['status']; ?></td>
                <td><?php echo $row_payment['payment_date']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
