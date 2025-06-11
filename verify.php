<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .center {
            text-align: center;
            margin-top: 20vh; /* Adjust as needed */
        }
        .center form {
            display: inline-block;
        }
        .center input[type="text"],
        .center input[type="submit"] {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="center">
<?php
// Check if the customer is logged in
if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    // Check if the customer has made a payment
    $query_check_payment = "SELECT * FROM payments WHERE customer_id = ? AND status = 'paid'";
    // Assuming you have a database connection
    $con = mysqli_connect("localhost", "root", "", "thegymdb");

    if ($stmt_check_payment = mysqli_prepare($con, $query_check_payment)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt_check_payment, "i", $customerId);

        // Execute statement
        if (mysqli_stmt_execute($stmt_check_payment)) {
            // Get the result set
            $result_check_payment = mysqli_stmt_get_result($stmt_check_payment);

            if ($result_check_payment) {
                $row_payment = mysqli_fetch_assoc($result_check_payment);

                // Check if the customer has a paid booking
                if ($row_payment) {
                    // Display a form for payment ID verification
                    echo "<form method='post' action='verify_payment.php'>";
                    echo "<div>Enter your Payment ID:</div>";
                    echo "<div><input type='text' name='payment_id'></div>";
                    echo "<div><input type='submit' value='Verify'></div>";
                    echo "</form>";
                } else {
                    // Customer has not paid, show a message or redirect
                    echo "<div>You need to make a booking and make its payment to access this page.</div>";
                }
            } else {
                echo "Error fetching result: " . mysqli_error($con);
            }
        } else {
            echo "Error executing query: " . mysqli_stmt_error($stmt_check_payment);
        }

        // Close the statement
        mysqli_stmt_close($stmt_check_payment);
    } else {
        echo "Error preparing statement: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    // Customer not logged in, redirect to login page or show a message
    echo "You need to log in to access this page.";
}
?>
</div>
</body>
</html>
