<?php
session_start();

$host = "localhost";
$username_db = "root";
$password_db = "";
$database = "thegymdb";

// Establish a connection to the database
$con = mysqli_connect($host, $username_db, $password_db, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = ""; // Initialize error message

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Login
        $username = $_POST['username'];
        $password = $_POST['password'];
        $userType = $_POST['user_type'];
    
        // Sanitize user input to prevent SQL injection
        $username = mysqli_real_escape_string($con, $username);
        $password = mysqli_real_escape_string($con, $password);
    
        if ($userType === 'admin') {
            // Query to check admin credentials
            $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        } elseif ($userType === 'customer') {
            // Query to check customer credentials
            $query = "SELECT * FROM customers WHERE username='$username'";
        } else {
            $error = "Invalid user type.";
        }
    
        if (!empty($query)) {
            $result = mysqli_query($con, $query);
    
            if (!$result) {
                die("Query failed: " . mysqli_error($con));
            }
    
            if ($row = mysqli_fetch_assoc($result)) {
                // Verify password for customers only
                if ($userType === 'customer') {
                    if (password_verify($password, $row['password'])) {
                        $_SESSION['customer_id'] = $row['customer_id']; // Set customer_id in the session

                        $_SESSION['customer'] = true;
                        header("Location: customer_dashboard.php");
                        exit();
                    } else {
                        $error = "Incorrect username or password. Please try again.";
                    }
                } elseif ($userType === 'admin') {
                    $_SESSION['admin'] = true;
                    header("Location: admin_dashboard.php");
                    exit();
                }
            } else {
                $error = "Username not found. Please check your credentials.";
            }
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Management System - Login</title>
    <style>
        body {
            background-image: url('gym.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            font-size: 18px;
        }

        h1 {
            color: blue;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: blue;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"],
        input[type="button"] {
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <h1>Gym Management System</h1>

    <!-- Login Form -->
    <form method="post" action="">
        <h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type">
            <option value="admin">Admin</option>
            <option value="customer">Customer</option>
        </select><br>
        <input type="submit" name="login" value="Login">
    </form>

    <!-- Error Message -->
    <div class="error"><?php echo $error; ?></div>

    <!-- Register Button -->
    <input type="button" value="Register" onclick="location.href='register.php';">
</body>
</html>
