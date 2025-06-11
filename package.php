<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Form</title>
    <style>
        body {
            background-color: yellowgreen; /* Set page background to yellowgreen */
            font-family: Arial, sans-serif;}
        .container {
            display: flex;
            margin: 20px
        }
        .form-container {
            flex: 0.3;
            margin-right: 20px;
            background-color: lightgreen; /* Added green background */
            padding: 20px;
            border-radius: 0.3px;
        }
        
        .package-list {
            flex: 3;
            background-color: white;
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
            background-color:whitesmoke;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Package Form</h2>
    <div class="container">
        <!-- Package Form -->
        <div class="form-container">
            <h3>Add New Package</h3>
            <form action="process_package.php" method="post" onsubmit="return validateForm()">
                <label for="name">Package Name:</label>
                <input type="text" name="name" id="name" required><br>
                <span class="error-message" id="name-error"></span><br>

                <label for="description">Description:</label><br>
                <textarea name="description" id="description" rows="4" cols="50" required></textarea><br>
                <span class="error-message" id="description-error"></span><br>

                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" required><br>
                <span class="error-message" id="amount-error"></span><br>

                <button type="submit">Save</button>
            </form>
        </div>

        <!-- Package List -->
        <div class="package-list">
            <h3>List of Packages</h3>
            <table>
                <thead>
                    <tr>
                        <th>Package Name</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch and display existing packages here from the database -->
                    <?php
                    // Connect to the database
                    $host = "localhost";
                    $username_db = "root";
                    $password_db = "";
                    $database = "thegymdb";
                    $con = mysqli_connect($host, $username_db, $password_db, $database);

                    // Check the connection
                    if (!$con) {
                        echo "<tr><td colspan='4'>Failed to connect to the database</td></tr>";
                    } else {
// Fetch existing packages from the database
$query = "SELECT * FROM packages";
$result = mysqli_query($con, $query);

// Check if there are any existing packages
if (mysqli_num_rows($result) > 0) {
    // Loop through each row and display package details
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr id='package-" . $row['package_id'] . "'>"; // Change 'id' to 'package_id'
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['description']}</td>";
        echo "<td>{$row['amount']}</td>";
        echo "<td><button onclick=\"deletePackage({$row['package_id']})\">Delete</button></td>"; // Change 'id' to 'package_id'
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No packages available</td></tr>";
}
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var description = document.getElementById("description").value;
            var amount = document.getElementById("amount").value;
            var isValid = true;

            if (name.trim() === "") {
                document.getElementById("name-error").innerText = "Please enter a package name";
                isValid = false;
            } else {
                document.getElementById("name-error").innerText = "";
            }

            if (description.trim() === "") {
                document.getElementById("description-error").innerText = "Please enter a description";
                isValid = false;
            } else {
                document.getElementById("description-error").innerText = "";
            }

            if (amount.trim() === "") {
                document.getElementById("amount-error").innerText = "Please enter an amount";
                isValid = false;
            } else {
                document.getElementById("amount-error").innerText = "";
            }

            return isValid;
        }

        function deletePackage(id) {
        fetch('delete_package.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ id: id }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete package');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remove the package from the UI
                const row = document.getElementById('package-' + id);
                if (row) {
                    row.remove();
                    alert('Package deleted successfully');
                } else {
                    alert('Package deleted successfully, but could not update UI');
                }
            } else {
                alert('Failed to delete package: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Failed to delete package: ' + error.message);
        });

        
    }



    </script>
</body>
</html>
