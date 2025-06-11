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

// Function to fetch the count of active customers
function getActiveCustomersCount($con) {
    $activeCustomersQuery = "SELECT COUNT(*) AS active_customers FROM customers WHERE status = 1";
    $activeCustomersResult = mysqli_query($con, $activeCustomersQuery);
    if ($activeCustomersResult && mysqli_num_rows($activeCustomersResult) > 0) {
        $activeCustomersRow = mysqli_fetch_assoc($activeCustomersResult);
        return $activeCustomersRow['active_customers'];
    } else {
        return 0;
    }
}

// Handle customer registration
if (isset($_POST['register'])) {
    // Your customer registration logic here...

    // Assuming registration is successful, increase the count of active customers
    $activeCustomersCount = getActiveCustomersCount($con);
    $activeCustomersCount++;
}

// Handle customer deletion
if (isset($_POST['delete'])) {
    // Your customer deletion logic here...

    // Assuming deletion is successful, decrease the count of active customers
    $activeCustomersCount = getActiveCustomersCount($con);
    $activeCustomersCount--;



    function getTotalPackagesCount($con) {
        $packagesCountQuery = "SELECT COUNT(*) AS total_packages FROM packages";
        $packagesCountResult = mysqli_query($con, $packagesCountQuery);
        if ($packagesCountResult && mysqli_num_rows($packagesCountResult) > 0) {
            $packagesCountRow = mysqli_fetch_assoc($packagesCountResult);
            return $packagesCountRow['total_packages'];
        } else {
            return 0;
        }
    }
    
    // Handle package addition
    if (isset($_POST['add_package'])) {
        // Your package addition logic here...
    
        // Assuming addition is successful, update the count of total packages
        $totalPackagesCount = getTotalPackagesCount($con);
    }
    
    // Handle package deletion
    if (isset($_POST['delete_package'])) {
        // Your package deletion logic here...
    
        // Assuming deletion is successful, update the count of total packages
        $totalPackagesCount = getTotalPackagesCount($con);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            display: flex;
            background-image: url('sol.jpg');
            color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #sidebar {
            background-color: Grey; /* Blue background color for the sidebar */
            padding: 20px;
            width: 200px;
            position: fixed;
            height: 100%;
        }

        #content {
            padding: 40px;
            flex: 1;
        }

        h1 {
            color: lawngreen;
            font-size: 34px;
            margin-bottom: 50px;
            text-align: center;
        }

        .blocks-container {
            display: flex;
            gap: 20px;
        }
        .block {
            background-color: ;
            color: white;
            padding: 5px;
            margin-bottom: 25px;
            border-radius: 5px;
            text-align: center;
            flex: 1;
        }

        #active-customers {
            background-color: Grey;
        }

        #total-membership {
            background-color: blue;
        }

        #total-packages {
            background-color: blueviolet;
        }

        #sidebar a {
            display: block;
            color: white;
            padding: 10px 0;
            text-decoration: none;
            
        }

        #sidebar a:hover {
            background-color: black;
        }

        #logout-btn {
            background-color: white;
            color: #4CAF50; /* Green text color */
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <!-- Sidebar links -->
        <a href="?module=home">HOME</a>
    <a href="customer_list.php">CUSTOMERS</a>
        <a href="customer_schedule.php">SCHEDULE</a>
        <a href="plan.php">PLANS</a>
        <a href="package.php">PACKAGE</a>
        <a href="view_booking.php">BOOKINGS</a>
        <a href="view_payment.php">PAYMENT</a>
        
    </div>

    <div id="content">
        <h1>Welcome To Admin Dashboard</h1>
        
        <!-- Home Content with Three Blocks -->
        <div class="block" id="active-customers">
            <h2>ACTIVE CUSTOMERS</h2>
            <h3><?php echo getActiveCustomersCount($con); ?></h3>
            <!-- Add dynamic content or data here -->
            
        </div>

        
            
            <!-- Add dynamic content or data here -->
            
            
        </div>
    </div>
    
    

    <!-- Logout button -->
    <form action="login.php" method="post">
        <button type="submit" id="logout-btn">Logout</button>
    </form>
</body>
</html>
