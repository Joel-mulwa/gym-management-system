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

// Fetch customer ID from the session
$customerId = $_SESSION['customer_id'];

// Fetch customer details from the database
$query_customer_details = "SELECT * FROM customers WHERE customer_id = $customerId";
$result_customer_details = mysqli_query($con, $query_customer_details);

// Check the query result
if (!$result_customer_details) {
    die("Query failed: " . mysqli_error($con));
}

// Fetch the customer details
$row_customer = mysqli_fetch_assoc($result_customer_details);

// Check if the form is submitted for updating details
if (isset($_POST['update_details'])) {
    // Retrieve and sanitize input values
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);

    // Update customer details in the database
    $update_query = "UPDATE customers SET fullname = '$fullname', username = '$username', email = '$email', password = '$password', contact = '$contact', gender = '$gender' WHERE customer_id = $customerId";

    if (mysqli_query($con, $update_query)) {
        // Display a JavaScript alert upon successful update
        echo '<script>alert("Customer details updated successfully!");</script>';
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('one.jpg'); /* Background image */
            background-size: cover;
            background-position: center;
            color: white;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center; /* Center align horizontally */
            align-items: center; /* Center align vertically */
            height: 100vh; /* Full viewport height */
        }

        form {
            width: 50%;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            color: black; /* Text color changed to black */
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        h2 {
            text-align: top center; /* Center align text */
        }

        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    

    <form action="" method="POST">
        <label for="fullname">Full Name:</label><br>
        <input type="text" name="fullname" value="<?php echo $row_customer['fullname']; ?>"><br>

        <label for="username">Username:</label><br>
        <input type="text" name="username" value="<?php echo $row_customer['username']; ?>"><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo $row_customer['email']; ?>"><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password"><br>

        <label for="contact">Contact:</label><br>
        <input type="text" name="contact" value="<?php echo $row_customer['contact']; ?>"><br>

        <label for="gender">Gender:</label><br>
        <select name="gender">
            <option value="Male" <?php if ($row_customer['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($row_customer['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($row_customer['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select><br>

        <button type="submit" name="update_details">Update Details</button>
    </form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
