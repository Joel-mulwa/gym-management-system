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
    header("Location: package.php?success=false&message=Failed to connect to the database");
    exit();
}
function getTotalPackagesCount($con) {
    $query = "SELECT COUNT(*) AS total_packages FROM packages";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_packages'];
}

// Handle package addition
if (isset($_POST['add_package'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    
    // Your package addition logic here...
    $sql = "INSERT INTO packages (name, description, amount) VALUES ('$name', '$description', '$amount')";
    
    if (mysqli_query($con, $sql)) {
        // Package added successfully
        $_SESSION['total_packages'] = getTotalPackagesCount($con); // Update total packages count in session
        header("Location: package.php"); // Redirect back to the package.php page
        exit();
    } else {
        // Error occurred while adding the package
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Handle package deletion
if (isset($_POST['delete_package'])) 
    $id = $_POST['id'];
    
    // Your package deletion logic here...
    $sql = "DELETE FROM packages WHERE id=$id";
    
    if (mysqli_query($con, $sql)) {
        // Package deleted successfully
        $_SESSION['total_packages'] = getTotalPackagesCount($con); // Update total packages count in session
        header("Location: package.php"); // Redirect back to the package.php page
        exit();
    } else {
        // Error occurred while deleting the package
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    // Perform database operation to insert the new package
    $query = "INSERT INTO packages (name, description, amount) VALUES ('$name', '$description', '$amount')";
    $result = mysqli_query($con, $query);

    // Check if the insertion was successful
    if ($result) {
        // Redirect back to package.php with success message
        header("Location: package.php?success=true&message=Package added successfully");
        exit();
    } else {
        // Redirect back to package.php with error message
        header("Location: package.php?success=false&message=Failed to add package: " . mysqli_error($con));
        exit();
    }
}

// If no form submission, redirect back to package.php
header("Location: package.php");
exit();
?>
