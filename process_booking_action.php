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

// Check if the form data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingId = mysqli_real_escape_string($con, $_POST['booking_id']);
    $action = mysqli_real_escape_string($con, $_POST['action']);

    // Perform the necessary actions based on $action
    if ($action === 'approved') {
        // Update the booking status to 'approved'
        $updateQuery = "UPDATE bookings SET status = 'approved' WHERE booking_id = $bookingId";
    } elseif ($action === 'declined') {
        // Update the booking status to 'declined'
        $updateQuery = "UPDATE bookings SET status = 'declined' WHERE booking_id = $bookingId";
    }

    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        // Provide a success response
        echo json_encode(['success' => true]);
    } else {
        // Provide an error response
        echo json_encode(['success' => false, 'message' => 'Failed to update booking status']);
    }
}

// Close the database connection
mysqli_close($con);
?>
