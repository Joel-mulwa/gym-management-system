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

// Fetch customer data from the database
$query = "SELECT customer_id, fullname, gender, email, contact FROM customers";
$result = mysqli_query($con, $query);

// Check the query result
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Handle edit action
if (isset($_POST['edit'])) {
    $editCustomerId = mysqli_real_escape_string($con, $_POST['editCustomerId']);
    // You can redirect to an edit page with the customer ID for more detailed editing
    header("Location: edit_customer.php?id=$editCustomerId");
    exit();
}

// Handle delete action
if (isset($_POST['delete'])) {
    $deleteCustomerId = mysqli_real_escape_string($con, $_POST['deleteCustomerId']);
    $deleteQuery = "DELETE FROM customers WHERE customer_id = $deleteCustomerId";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if (!$deleteResult) {
        die("Delete query failed: " . mysqli_error($con));
    }

    // Redirect to refresh the page after deletion
    header("Location: admin_dashboard.php");
    exit();
}

// Handle update validity action
if (isset($_POST['update_validity'])) {
    $customerId = mysqli_real_escape_string($con, $_POST['customerId']);
    $validity = mysqli_real_escape_string($con, $_POST['validity']);
    $updateQuery = "UPDATE customers SET validity = '$validity' WHERE customer_id = $customerId";
    $updateResult = mysqli_query($con, $updateQuery);

    if (!$updateResult) {
        die("Update query failed: " . mysqli_error($con));
    }

    // Redirect to refresh the page after updating validity
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .actions {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <h2>Customer List</h2>
    <a href="manage_customer.php" class="register-btn">Register New Customer</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Actions</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['customer_id']; ?></td>
                    <td><?php echo $row['fullname']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td class="actions">
                        <form method="post" action="">
                            <input type="hidden" name="editCustomerId" value="<?php echo $row['customer_id']; ?>">
                            <input type="submit" name="edit" value="Edit">
                        </form>
                        <form method="post" action="">
                            <input type="hidden" name="deleteCustomerId" value="<?php echo $row['customer_id']; ?>">
                            <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this customer?');">
                        </form>
                    </td>
                    <!-- Add more cells for additional columns -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>

</html>

<?php
// Close the database connection
mysqli_close($con);
?>
