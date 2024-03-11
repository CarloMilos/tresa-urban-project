<?php
// Include any necessary files and configurations
require 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate form data (you can add more validation as needed)
    if (empty($name) || empty($email) || empty($message)) {
        // Handle validation errors (e.g., display error message or redirect back to the form with an error)
        // For simplicity, let's redirect back to the form with an error message
        header("Location: feedback.php?error=emptyfields");
        exit();
    }

    // Sanitize data (optional but recommended)
    $name = htmlspecialchars($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($message);

    // Insert data into the database
    // You would typically use prepared statements to prevent SQL injection
    $sql = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $message]);

    // Provide feedback confirmation
    // For simplicity, let's redirect to a thank you page
    header("Location: thank_you.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS styles here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --yellow: #FFBD13;
            --blue: #4383FF;
            --blue-d-1: #3278FF;
            --light: #F5F5F5;
            --grey: #AAA;
            --white: #FFF;
            --shadow: 8px 8px 30px rgba(0,0,0,.05);
        }

        body {
            background: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .wrapper {
            background: var(--white);
            padding: 2rem;
            max-width: 576px;
            width: 100%;
            border-radius: .75rem;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .wrapper h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .rating {
            display: flex;
            justify-content: center;
            align-items: center;
            grid-gap: .5rem;
            font-size: 2rem;
            color: var(--yellow);
            margin-bottom: 2rem;
        }

        .rating .star {
            cursor: pointer;
        }

        .rating .star.active {
            opacity: 0;
            animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
        }

        @keyframes animate {
            0% {
                opacity: 0;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .rating .star:hover {
            transform: scale(1.1);
        }

        textarea {
            width: 100%;
            background: var(--light);
            padding: 1rem;
            border-radius: .5rem;
            border: none;
            outline: none;
            resize: none;
            margin-bottom: .5rem;
        }

        .btn-group {
            display: flex;
            grid-gap: .5rem;
            align-items: center;
        }

        .btn-group .btn {
            padding: .75rem 1rem;
            border-radius: .5rem;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: .875rem;
            font-weight: 500;
        }

        .btn-group .btn.submit {
            background: var(--blue);
            color: var(--white);
        }

        .btn-group .btn.submit:hover {
            background: var(--blue-d-1);
        }

        .btn-group .btn.cancel {
            background: var(--white);
            color: var(--blue);
        }

        .btn-group .btn.cancel:hover {
            background: var(--light);
        }
    </style>
    <title>Form Reviews</title>
</head>
<body>
    <div class="wrapper">
        <h3>Your Opinion </h3>
        <form action="#" id="feedbackForm">
            <div class="rating">
                <input type="hidden" name="rating" id="ratingValue">
                <i class='bx bx-star star' data-value="1"></i>
                <i class='bx bx-star star' data-value="2"></i>
                <i class='bx bx-star star' data-value="3"></i>
                <i class='bx bx-star star' data-value="4"></i>
                <i class='bx bx-star star' data-value="5"></i>
            </div>
            <textarea name="opinion" id="opinion" cols="30" rows="5" placeholder="Your opinion..."></textarea><br><br>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="bug">Bug</option>
                <option value="map">Map</option>
                <option value="feature_request">Feature Request</option>
            </select><br><br>
            <div class="btn-group">
                <button type="submit" class="btn submit">Submit</button>
                <button type="button
