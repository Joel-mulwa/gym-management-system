<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract schedule data from POST request
    $customerId = $_POST['customerId'];
    $startDate = $_POST['startDate'];
    $duration = $_POST['duration'];
    $timeIn = $_POST['timeIn'];
    $timeOut = $_POST['timeOut'];

    // Calculate end date based on start date and duration
    $endDate = date('Y-m-d', strtotime($startDate . ' + ' . $duration . ' days'));

    // Prepare and execute SQL statement to insert into the schedule table
    $query = "INSERT INTO schedule (customer_id, start_date, duration, time_in, time_out, end_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'isssss', $customerId, $startDate, $duration, $timeIn, $timeOut, $endDate);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Schedule saved successfully!";
        } else {
            echo "Error executing SQL statement: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing SQL statement: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    echo "Invalid request method!";
}
?>
