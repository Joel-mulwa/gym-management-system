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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $plan = $_POST['plan'];

    // Check if the plan already exists
    $existingPlanQuery = "SELECT plan_id FROM plans WHERE plan_type = '$plan'";
    $existingPlanResult = mysqli_query($con, $existingPlanQuery);

    if (mysqli_num_rows($existingPlanResult) > 0) {
        // Redirect back to the form with an error message
        $error_message = "Plan already exists.";
        header("Location: plan.php?error=true&message=" . urlencode($error_message));
        exit();
    }

    // Insert data into the database without specifying 'plan_id'
    $query = "INSERT INTO plans (plan_type) VALUES ('$plan')"; // Exclude 'plan_id' for auto-increment primary key
    $result = mysqli_query($con, $query);

    // Check if the insertion was successful
    if ($result) {
        // Redirect back to the form with a success message
        header("Location: plan.php?success=true");
        exit();
    } else {
        // Redirect back to the form with an error message
        $error_message = mysqli_error($con);
        header("Location: plan.php?error=true&message=" . urlencode($error_message));
        exit();
    }
}

// Fetch existing plans from the database
$query = "SELECT * FROM plans";
$result = mysqli_query($con, $query);

// Check if there are any existing plans
if ($result) {
    $plans = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $plans = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Form</title>
    <style>
        body {
            background-color: whitesmoke;
            color: black;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
        }

        .form-container {
            flex: 0.3;
            margin-right: 20px;
            background-color: gray;
            padding: 20px;
            border-radius: 0.3px;
        }

        .plan-list {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button[type="submit"] {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Plan Form -->
        <div class="form-container">
            <h2>Add New Plan</h2>
            <form action="plan.php" method="post">
                <label for="plan">Plan:</label>
                <select name="plan" id="plan" required>
                    <option value="one day">One Day</option>
                    <option value="one week">One Week</option>
                    <option value="one month">One Month</option>
                    <option value="three months">Three Months</option>
                    <option value="six months">Six Months</option>
                    <option value="one year">One Year</option>
                </select><br><br>

                <div class="action-buttons">
                    <button type="submit">ADD</button>
                </div>
            </form>
        </div>

        <!-- Plan List -->
        <div class="plan-list">
            <h2>Plan List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plans as $plan): ?>
                        <tr id="plan-<?php echo $plan['plan_id']; ?>">
                            <td><?php echo $plan['plan_id']; ?></td>
                            <td><?php echo $plan['plan_type']; ?></td>
                            <td><button onclick="deletePlan(<?php echo $plan['plan_id']; ?>)">Delete</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript for plan deletion -->
    <script>
        // Function to delete a plan
        function deletePlan(plan_id) {
            fetch('delete_plan.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ plan_id: plan_id }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to delete plan');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove the plan from the UI
                    const row = document.getElementById('plan-' + plan_id);
                    row.remove();
                } else {
                    alert('Failed to delete plan: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Failed to delete plan: ' + error.message);
            });
        }
    </script>
</body>
</html>
