<?php
require 'config.php';
// Set cache-control header
header("Cache-Control: max-age=604800"); // Set max-age to a valid value

// Ensure 'x-content-type-options' header is included in the response
header("X-Content-Type-Options: nosniff");


// Define category mapping
$category_mapping = [
    'Map' => 'Map',
    'Bug' => 'Bug',
    'Feature Request' => 'Feature Request'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Validate form data (you can add more validation as needed)
    if (empty($name) || empty($email)) {
        // Handle validation errors (e.g., display error message or redirect back to the form with an error)
        // For simplicity, let's redirect back to the form with an error message
        header("Location: feedback.php?error=emptyfields");
        exit();
    }

    // Sanitize data (optional but recommended)
    $name = htmlspecialchars($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Handle category
    if (isset($_POST['category']) && isset($category_mapping[$_POST['category']])) {
        $category = $category_mapping[$_POST['category']];
    } else {
        // Default to an empty category or handle the error as needed
        $category = '';
    }

    // Handle rating
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0; // Default to 0 if not set

    // Handle message
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; // Default to an empty string if not set

    // Insert data into the database
    // You would typically use prepared statements to prevent SQL injection
    $sql = "INSERT INTO feedback (name, email, category, rating, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $category, $rating, $message]);

    // Provide feedback confirmation
    // For simplicity, let's redirect to a thank you page
    header("Location: thank_you.php");
    exit();
}

// Set the correct content-type header
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your custom CSS styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
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

.container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 40px;
    max-width: 400px;
    width: 100%;
}

h3 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
    outline: none;
}

/* Adjusted CSS with 'text-size-adjust' */
select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"></path></svg>');
    background-repeat: no-repeat;
    background-position-x: 98%;
    background-position-y: center;
    background-color: #ffffff;
    text-size-adjust: 100%; /* Added */
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

.message {
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
}

.stars {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.star {
    font-size: 24px;
    color: #ffd700; /* Changed to gold */
    cursor: pointer;
    transition: color 0.3s ease;
}

.star:hover,
.star.active {
    color: #ffd700;
}

.buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
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

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease; /* Added color transition */
}

.btn-primary {
    background-color: #007bff;
    border: 1px solid #ffffff;
    color: #007bff;
}

.btn-group .btn.submit:hover {
    background: var(--blue); /* Keep the original background color */
}

.btn-secondary {
    background-color: #ffffff;
    border: 1px solid #007bff;
    color: #007bff;
}

.btn-secondary:hover {
    background-color: #f2f2f2;
}

    </style>
    <title>Form Reviews</title>
</head>
<body>
    <div class="wrapper">
        <h3>Your Opinion</h3>
        <form action="#" id="feedbackForm" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required autocomplete="name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="category">Feedback Category:</label>
                <select name="category" id="category" required autocomplete="category">
                    <option value="" disabled selected>Select a category</option>
                    <option value="Map">Map</option>
                    <option value="Bug">Bug</option>
                    <option value="Feature Request">Feature Request</option>
                </select>
            </div>
            <div class="message">
                <p>Rate Us!</p>
            </div>
            <div class="rating">
                <input type="hidden" name="rating" id="ratingValue">
                <i class='bx bx-star star' data-value="1"></i>
                <i class='bx bx-star star' data-value="2"></i>
                <i class='bx bx-star star' data-value="3"></i>
                <i class='bx bx-star star' data-value="4"></i>
                <i class='bx bx-star star' data-value="5"></i>
            </div>
            <div class="form-group">
                <label for="message">Leave us a Message!</label>
                <textarea name="message" id="message" cols="30" rows="5" placeholder="Your message..." required autocomplete="message"></textarea>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn submit">Submit</button>
                <button type="button" class="btn cancel">Cancel</button>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const allStars = document.querySelectorAll('.rating .star');
        const ratingValue = document.getElementById('ratingValue');

        allStars.forEach((star) => {
            star.addEventListener('click', function () {
                const rating = parseInt(this.dataset.value);
                ratingValue.value = rating;

                allStars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.replace('bx-star', 'bxs-star');
                    } else {
                        star.classList.replace('bxs-star', 'bx-star');
                    }
                });
            });
        });
    });
</script>

</body>
</html>
