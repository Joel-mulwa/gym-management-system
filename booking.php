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

// Fetch schedules from the database
$query_schedules = "SELECT * FROM schedules";
$result_schedules = mysqli_query($con, $query_schedules);

// Fetch plans from the database
$query_plans = "SELECT * FROM plans";
$result_plans = mysqli_query($con, $query_plans);

// Fetch packages from the database
$query_packages = "SELECT * FROM packages";
$result_packages = mysqli_query($con, $query_packages);

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('gymm.jpg');;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #555;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Booking Page</h1>

    <form action="process_booking.php" method="post">
        <h2>Book a Session</h2>

        
        <label for="schedule">Select Schedule:</label>
        <select id="schedule" name="schedule" required>
            <option value="morning">Morning (8:00 AM - 12:00 PM)</option>
            <option value="afternoon">Afternoon (12:00 PM - 4:00 PM)</option>
            <option value="evening">Evening (4:00 PM - 8:00 PM)</option> ?>
        </select>

        <label for="plan">Select Plan:</label>
        <select id="plan" name="plan" required>
            <?php while ($row_plan = mysqli_fetch_assoc($result_plans)) { ?>
                <option value="<?php echo $row_plan['plan_id']; ?>"><?php echo $row_plan['plan_type']  ?></option>
            <?php } ?>
        </select>

        <label for="package">Select Package:</label>
        <select id="package" name="package" required>
            <?php while ($row_package = mysqli_fetch_assoc($result_packages)) { ?>
                <option value="<?php echo $row_package['package_id']; ?>"><?php echo $row_package['name'] . ' - ' . $row_package['description'] . ' - ' . $row_package['amount']; ?></option>
            <?php } ?>
        </select>

        <button type="submit">Book Now</button>
        <a href="booking_list.php"><button type="button" style="float: right;">Check Status</button></a>

    </form>
</body>
</html>
