<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the payment ID is provided
    if (isset($_POST['payment_id']) && !empty($_POST['payment_id'])) {
        $enteredPaymentId = $_POST['payment_id'];
        
        // Retrieve the payment IDs associated with the customer from the database
        $customerId = $_SESSION['customer_id'];
        $query_get_payment_ids = "SELECT payment_id FROM payments WHERE customer_id = ? AND status = 'paid'";
        
        // Assuming you have a database connection
        $con = mysqli_connect("localhost", "root", "", "thegymdb");

        if ($stmt_get_payment_ids = mysqli_prepare($con, $query_get_payment_ids)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt_get_payment_ids, "i", $customerId);

            // Execute statement
            if (mysqli_stmt_execute($stmt_get_payment_ids)) {
                // Get the result set
                $result_get_payment_ids = mysqli_stmt_get_result($stmt_get_payment_ids);

                if ($result_get_payment_ids) {
                    $correctPaymentId = false;

                    while ($row_payment_id = mysqli_fetch_assoc($result_get_payment_ids)) {
                        // Check if any of the retrieved payment IDs match the entered payment ID
                        if ($row_payment_id['payment_id'] == $enteredPaymentId) {
                            $correctPaymentId = true;
                            break;
                        }
                    }

                    // Check if the entered payment ID matches any of the stored payment IDs
                    if ($correctPaymentId) {
                        // Payment ID is correct, generate OTP and QR code
                        $otp = sprintf('%06d', mt_rand(0, 999999));
                        $otpUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=' . $otp;

                        // Display QR code and OTP
                        echo "<div style='text-align:center;'>Scan the QR Code below to acquire verification code</div>";
                        echo "<div style='text-align:center;'><img src='$otpUrl' alt='QR Code'></div>";
                        echo "<div style='text-align:center;'>Use the following OTP if you can't scan the QR code: <strong>$otp</strong></div>";
                    } else {
                        // Payment ID is incorrect
                        echo "<div style='text-align:center;'>Payment ID is incorrect. Please confirm and try again.</div>";
                    }
                } else {
                    echo "Error fetching result: " . mysqli_error($con);
                }
            } else {
                echo "Error executing query: " . mysqli_stmt_error($stmt_get_payment_ids);
            }

            // Close the statement
            mysqli_stmt_close($stmt_get_payment_ids);
        } else {
            echo "Error preparing statement: " . mysqli_error($con);
        }

        // Close the database connection
        mysqli_close($con);
    } else {
        // Payment ID is not provided
        echo "<div style='text-align:center;'>Payment ID is required. Please enter the Payment ID.</div>";
    }
} else {
    // Redirect if accessed directly without submitting the form
    header("Location: index.php");
    exit();
}
?>
