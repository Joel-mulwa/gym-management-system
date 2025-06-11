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
    die("Connection failed: " . mysqli_connect_error());
}

// Function to update IDs after deletion
function updateIdsAfterDeletion($con, $tableName, $deletedIdField, $startId) {
    $updateQuery = "UPDATE $tableName SET $deletedIdField = $deletedIdField - 1 WHERE $deletedIdField > ?";
    $stmt = mysqli_prepare($con, $updateQuery);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $startId);

        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            echo "IDs updated successfully.";
        } else {
            echo "Error updating IDs: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($con);
    }
}

// Example of updating IDs after a customer with ID 1 is deleted
updateIdsAfterDeletion($con, 'customers', 'customer_id', 1);
updateIdsAfterDeletion($con, 'plans', 'plan_id', 1);
updateIdsAfterDeletion($con, 'packages', 'package_id', 1);
updateIdsAfterDeletion($con, 'bookings', 'booking_id', 1);
updateIdsAfterDeletion($con, 'schedule', 'schedule_id', 1);

// Close the database connection
mysqli_close($con);
?>
