
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .payment-instructions {
            margin-top: 20px;
        }

        .check-status-button, .paid-button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Make Payment</h1>

    <div class="payment-instructions">
        <p>To complete your payment, follow the instructions below:</p>
        <ol>
            <li>Go to M-Pesa on your phone</li>
            <li>Select "Lipa na M-Pesa"</li>
            <li>Select "Paybill"</li>
            <li>Enter Paybill number: <strong>400200</strong></li>
            <li>Enter Account number: <strong>0713876720</strong></li>
            <li>Enter the amount: <strong><?php echo isset($_GET['amount']) ? $_GET['amount'] : ''; ?></strong></li>
            <li>Enter your M-Pesa PIN and confirm</li>
        </ol>
        <p>Once the payment is complete, your booking will be confirmed.</p>
    </div>

    <form method="post" action="update_payment_status.php">
        <input type="hidden" name="payment_status" value="paid">
        <button type="submit" class="paid-button">Paid</button>
    </form>

    
</body>
</html>