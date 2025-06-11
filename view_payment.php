<!-- view_payment.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: purple;
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
    <h1>View Payment Details</h1>

    <?php
    // Assuming you have a database connection here
    $host = "localhost";
    $username_db = "root";
    $password_db = "";
    $database = "thegymdb";

    $con = mysqli_connect($host, $username_db, $password_db, $database);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch payment information for all bookings
    $query_payment_info = "SELECT * FROM payments";
    $stmt_payment_info = mysqli_prepare($con, $query_payment_info);

    // Check for errors in the prepare statement
    if ($stmt_payment_info) {
        // Execute statement
        if (mysqli_stmt_execute($stmt_payment_info)) {
            // Get the result set
            $result_payment_info = mysqli_stmt_get_result($stmt_payment_info);

            if ($result_payment_info) {
                if (mysqli_num_rows($result_payment_info) > 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Payment ID</th>";
                    echo "<th>Booking ID</th>";
                    echo "<th>Amount</th>";
                    echo "<th>Status</th>";
                    echo "<th>Transaction ID</th>";
                    echo "<th>Payment Date</th>";
                    echo "</tr>";

                    while ($row_payment = mysqli_fetch_assoc($result_payment_info)) {
                        echo "<tr>";
                        echo "<td>{$row_payment['payment_id']}</td>";
                        echo "<td>{$row_payment['booking_id']}</td>";
                        echo "<td>{$row_payment['amount']}</td>";
                        echo "<td>{$row_payment['status']}</td>";
                        echo "<td>{$row_payment['transaction_id']}</td>";
                        echo "<td>{$row_payment['payment_date']}</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No payment details found.";
                }
            } else {
                echo "Error fetching result: " . mysqli_error($con);
            }
        } else {
            echo "Error executing query: " . mysqli_stmt_error($stmt_payment_info);
        }

        // Close the statement
        mysqli_stmt_close($stmt_payment_info);
    } else {
        echo "Error preparing statement: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
    ?>
</body>
</html>
