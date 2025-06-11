<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Algerian, sans-serif;
            margin: 0;
            height: 100vh;
            background-image: url('peace.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
        }

        .overlay {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center vertically */
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for text */
        }

        .about-content {
            max-width: 600px;
            text-align: center;
            color: #333;
        }

        h1 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <h1>About Us</h1>
        <div class="about-content">
            <p>
                In our gym, we are committed to providing a welcoming and motivating environment
                for your fitness journey. Whether you are a beginner or an experienced fitness enthusiast,
                our facilities and trained staff are here to support you.
            </p>
            <p>
                Join us today and embark on a path to a healthier and happier lifestyle.
            </p>
        </div>
    </div>
</body>
</html>
