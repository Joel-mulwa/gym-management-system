<?php
// get_customers.php

include('db_connect.php');

// Check the connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT customer_id, fullname FROM customers";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($con));
}

$customers = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $customers[] = $row;
    }
}

// Close the database connection
mysqli_close($con);

echo json_encode($customers);
?>
