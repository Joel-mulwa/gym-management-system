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

if (isset($_POST['register'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $insert_query = "INSERT INTO customers (fullname, username, password, contact, gender, email) 
                    VALUES ('$fullname', '$username', '$password', '$contact', '$gender', '$email')";

    if (mysqli_query($con, $insert_query)) {
        $registrationSuccess = true;

        $updateActiveCustomersQuery = "UPDATE customers SET status = 1 WHERE customer_id = (SELECT MAX(customer_id) FROM customers)";
        mysqli_query($con, $updateActiveCustomersQuery);
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gym System Registration</title>
   
    <style>
        body {
            background-image: url('pic.jpg'); 
            background-size: cover;
            background-position: center;
            color: white;
        }

        #loginbox {
            margin-top: 50px;
        }

        .form-vertical {
            max-width: 500px;
            margin: auto;
            background-color: #3498db;
        }

        .main_input_box {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .form-success {
            margin-top: 20px;
            text-align: center;
            color: green;
        }

        .login-btn {
            display: ruby-base-container;
            width: 10%;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            background-color: #4CAF50;
            color: black;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="loginbox">
        <form id="registerform" action="" method="POST" class="form-vertical">
            <div class="control-group normal_text">
                <h3>Enter your details here</h3>
            </div>

            <div class="controls">
                <label for="fullname">Fullname:</label>
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-pencil"></i></span><input type="text" name="fullname" id="fullname" placeholder="Fullname" />
                </div>
            </div>

            <br>

            <div class="controls">
                <label for="fullname">Username:</label>
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-pencil"></i></span><input type="text" name="username" id="username" placeholder="username" />
                </div>
            </div>

            <br>

            <div class="controls">
                <label for="password">Password:</label>
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-asterisk"></i></span><input type="password" name="password" id="password" placeholder="Password" />
                </div>
            </div>

            <br>

            <div class="controls">
                <label for="password">Contact:</label>
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-asterisk"></i></span><input type="contact" name="contact" id="contact" placeholder="Contact" />
                </div>
            </div>

            <br>

            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-user"></i></span>
                    <select name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-mail"></i></span><input type="email" name="email" id="email" placeholder="Email" />
                </div>
            </div>

            <br>

            <div class="form-actions">
                <span class="pull-right"><button class="btn btn-info" type="submit" name="register">Submit Details</button></span>
            </div>

            <?php
            if (isset($_POST['register'])) {
                // Handle registration logic
                // ... (your registration logic)
                echo "<div class='form-success'>
                        Registration successful! Please log in.
                    </div>";
            }
            ?>
        </form>

        <a href="login.php" class="login-btn">Back to Login</a>
    </div>
</body>

</html>
