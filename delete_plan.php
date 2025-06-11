<?php
session_start();

$host = "localhost";
$username_db = "root";
$password_db = "";
$database = "thegymdb";

// Establish a connection to the database
$con = mysqli_connect($host, $username_db, $password_db, $database);

// Check the connection
if (!$con) {
    // Send error response if connection fails
    echo json_encode(['success' => false, 'message' => 'Failed to connect to the database']);
    exit();
}

// Check if the request method is POST and if 'plan_id' parameter exists
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['plan_id'])) {
    // Sanitize plan ID
    $plan_id = mysqli_real_escape_string($con, $_POST['plan_id']);

    // Delete the plan from the database
    $query = "DELETE FROM plans WHERE plan_id = $plan_id";
    $result = mysqli_query($con, $query);

    // Check if deletion was successful
    if ($result) {
        // Reset auto-increment value for the plan_id column
        $resetQuery = "ALTER TABLE plans AUTO_INCREMENT = 1";
        mysqli_query($con, $resetQuery);

        // Send success response
        echo json_encode(['success' => true]);
        exit();
    } else {
        // Send error response
        echo json_encode(['success' => false, 'message' => 'Failed to delete plan']);
        exit();
    }
} else {
    // Send error response if 'plan_id' parameter is missing
    echo json_encode(['success' => false, 'message' => 'Plan ID parameter is missing']);
    exit();
}
?>
