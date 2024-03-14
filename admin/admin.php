<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        h2 {
            margin-top: 50px;
            text-align: center;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .dashboard-button1 {
            background-color: #ff5757;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            outline: none;
            margin: 0 10px;
        }
                .dashboard-button2 {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            outline: none;
            margin: 0 10px;
        }


        .dashboard-button:hover {
            background-color: #e64141;
        }
    </style>
</head>
<body>
    <h2>Welcome to Admin Dashboard</h2>
    <div class="button-container">
        <button class="dashboard-button2" onclick="location.href='adminverified.php'">Verified Posts</button>
        <button class="dashboard-button1" onclick="location.href='adminunverified.php'">Unverified Posts</button>
    </div>
</body>
</html>
