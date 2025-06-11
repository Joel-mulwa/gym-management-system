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

// Check if customer_id is set in the session
if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $schedule = mysqli_real_escape_string($con, $_POST['schedule']);
        $planId = mysqli_real_escape_string($con, $_POST['plan']);
        $packageId = mysqli_real_escape_string($con, $_POST['package']);

        // Insert the booking into the database
        $insertBookingQuery = "INSERT INTO bookings (customer_id, schedule, plan_id, package_id, status)
                               VALUES ($customerId, '$schedule', $planId, $packageId, 'pending')";
        $result = mysqli_query($con, $insertBookingQuery);

        if ($result) {
            // Booking successfully inserted
            // Redirect to booking_list.php
            header("Location: booking_list.php");
            exit(); // Ensure that no further code is executed after the redirection
        } else {
            // Handle the case where the booking insertion fails
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    // Handle the case where customer_id is not set in the session
    echo "Error: customer_id not set in the session.";
}

// Close the database connection
mysqli_close($con);
?>
