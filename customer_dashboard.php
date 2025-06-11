<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden; /* Hide scroll bars */
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            height: 100%;
            overflow-y: auto;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li a {
            display: block;
            padding: 30px;
            font-size: 20px;
            text-decoration: none;
            color: inherit;
            transition: color 0.3s;
        }
        .sidebar ul li a:hover {
            color: green;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #0056b3;
        }
        /* Slideshow */
        .slideshow {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>
    <script>
        // JavaScript for Slideshow
        let currentImageIndex = 0;
        const images = ['one.jpg', 'sol.jpg', 'gymm.jpg'];

        function changeBackgroundImage() {
            document.body.style.backgroundImage = `url('${images[currentImageIndex]}')`;
            currentImageIndex = (currentImageIndex + 1) % images.length;
            setTimeout(changeBackgroundImage, 5000); // Change image every 5 seconds
        }

        // Initialize the slideshow
        window.onload = changeBackgroundImage;
    </script>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="customer_dashboard.php">Home</a></li>
                <li><a href="user.php">User profile</a></li>
                <li><a href="booking.php">Bookings</a></li>
                <li><a href="payment.php">Payment</a></li>
                <li><a href="verify.php">Verification</a></li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <h1>Welcome Customer</h1>
        </div>
    </div>
    <!-- Logout Button -->
    <form method="POST" action="logout.php">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
    <!-- Slideshow Container -->
    <div class="slideshow"></div>
</body>
</html>
