<?php
session_start();

$registrationSuccess = false;

$host = "localhost";
$username_db = "root";
$password_db = "";
$database = "thegymdb";

$con = mysqli_connect($host, $username_db, $password_db, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['register'])) {
    // Retrieve and sanitize input values
    $customerId = $_POST['customer_id'];
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $email = mysqli_real_escape_string($con, $_POST['email']); // Add the email field

    // Update customer details in the database
    $update_query = "UPDATE customers SET fullname = '$fullname', username = '$username', password = '$password', contact = '$contact', gender = '$gender', email = '$email' WHERE customer_id = $customerId";

    if (mysqli_query($con, $update_query)) {
        $registrationSuccess = true;
        echo "Customer details updated successfully!";
        header("Location: customer_list.php"); // Redirect to customer list after successful update
        exit(); // Stop further execution
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Fetch customer details based on customer ID
$customerId = $_GET['id'];
$query = "SELECT * FROM customers WHERE customer_id = '$customerId'";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error: " . $query . "<br>" . mysqli_error($con);
} else {
    $row = mysqli_fetch_assoc($result);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Customer Details</title>
    <style>
        body {
            background-image: url('sol.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            width: 65%;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }

        .form-container {
            width: 40%;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: left;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Edit Customer Details</h2>
    <form id="edit_customer_form" action="" method="POST">
        <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
        <label for="fullname">Fullname:</label><br>
        <input type="text" name="fullname" value="<?php echo $row['fullname']; ?>"><br>

        <label for="username">Username:</label><br>
        <input type="text" name="username" value="<?php echo $row['username']; ?>"><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password"><br>

        <label for="contact">Contact:</label><br>
        <input type="text" name="contact" value="<?php echo $row['contact']; ?>"><br>

        <label for="gender">Gender:</label><br>
        <select name="gender">
            <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($row['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select><br>

        <label for="email">Email:</label><br>
        <input type="text" name="email" value="<?php echo $row['email']; ?>"><br>

        <input type="submit" name="register" value="Update Details">
    </form>
</div>
</body>
</html>
