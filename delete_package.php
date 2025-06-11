<?php
// Check if ID parameter is present
if (isset($_POST['id'])) {
    // Get the package ID from the POST request
    $package_id = $_POST['id'];

    // Connect to the database
    $host = "localhost";
    $username_db = "root";
    $password_db = "";
    $database = "thegymdb";
    $con = mysqli_connect($host, $username_db, $password_db, $database);

    // Check the connection
    if (!$con) {
        echo json_encode(['success' => false, 'message' => 'Failed to connect to the database']);
        exit();
    }

    // Attempt to delete the package from the database
   // Attempt to delete the package from the database
$query = "DELETE FROM packages WHERE package_id = $package_id";
$result = mysqli_query($con, $query);


    // Check if the deletion was successful
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Package deleted successfully']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete package: ' . mysqli_error($con)]);
        exit();
    }
} else {
    // ID parameter is missing
    echo json_encode(['success' => false, 'message' => 'ID parameter is missing']);
    exit();
}
?>
