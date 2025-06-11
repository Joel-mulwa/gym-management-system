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

// Assuming you have a session variable for customer_id
if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];
}

// Fetch necessary details from the bookings and packages tables using a JOIN
$queryBookingDetails = "SELECT b.booking_id, p.amount AS package_amount
                        FROM bookings b
                        JOIN packages p ON b.package_id = p.package_id
                        WHERE b.customer_id = ? AND b.status = 'approved'";
$stmtBookingDetails = mysqli_prepare($con, $queryBookingDetails);

// Check for errors in the prepare statement
if (!$stmtBookingDetails) {
    die("Error preparing statement: " . mysqli_error($con));
}

// Bind parameters
mysqli_stmt_bind_param($stmtBookingDetails, "i", $customerId);

// Execute statement
if (!mysqli_stmt_execute($stmtBookingDetails)) {
    die("Error executing query: " . mysqli_stmt_error($stmtBookingDetails));
}

// Get the result set
$resultBookingDetails = mysqli_stmt_get_result($stmtBookingDetails);

// Check if any rows are returned
if ($rowBooking = mysqli_fetch_assoc($resultBookingDetails)) {
    $bookingId = $rowBooking['booking_id'];

    $packageAmount = $rowBooking['package_amount'];

    // Generate necessary details
    $paymentId = uniqid('payment_');
    $transactionId = uniqid('transaction_');
    $paymentDate = date('Y-m-d H:i:s');
    $paymentStatus = 'paid'; // Assuming the payment is successful

    // Insert payment details into the payments table
    $queryInsertPayment = "INSERT INTO payments (payment_id, customer_id, booking_id, amount, status, transaction_id, payment_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsertPayment = mysqli_prepare($con, $queryInsertPayment);

    // Check for errors in the prepare statement
    if (!$stmtInsertPayment) {
        die("Error preparing statement: " . mysqli_error($con));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmtInsertPayment, "ssdssss", $paymentId, $customerId, $bookingId, $packageAmount, $paymentStatus, $transactionId, $paymentDate);

    // Execute statement
    if (!mysqli_stmt_execute($stmtInsertPayment)) {
        die("Error executing query: " . mysqli_stmt_error($stmtInsertPayment));
    }

    // Update the booking status in the bookings table
    $queryUpdateStatus = "UPDATE bookings SET status = ? WHERE booking_id = ?";
    $stmtUpdateStatus = mysqli_prepare($con, $queryUpdateStatus);

    // Check for errors in the prepare statement
    if (!$stmtUpdateStatus) {
        die("Error preparing statement: " . mysqli_error($con));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmtUpdateStatus, "si", $paymentStatus, $bookingId);

    // Execute statement
    if (!mysqli_stmt_execute($stmtUpdateStatus)) {
        die("Error executing query: " . mysqli_stmt_error($stmtUpdateStatus));
    }

    echo "Payment successful. Payment ID: $paymentId";
} else {
    echo "No approved bookings found for the customer.";
}

// Close the database connection
mysqli_close($con);
?>
