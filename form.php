<?php
include 'dbcon.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRESA Resident Input Form</title>

</head>
<body>

    <h1> By Completing this form you are authorising this form data to be added to the TRESA Urban Nature Reserve Map Database </h1>
    <h3> If you would like to opt out of having your data added to the map, tick the final box!</h3>

    <form action="formpost.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="uname">Name:</label>
            <input type="text" id="name" name="uname" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="uaddress">1st line of Address:</label>
            <input type="text" id="addresss" name="uaddress" required>
        </div>
        <div>
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode" required>
        </div>
        <div>
            <label for="dimensions">Dimensions:</label>
            <input type="number" id="dimensions" name="dimensions" required>
            <select name="unit">
                <option value="cm2">cm<sup>2</sup></option>
                <option value="m2">m<sup>2</sup></option>
            </select>
        </div>
        <div>
            <label for="garden-description">Garden Description:</label><br>
            <textarea id="garden-description" name="garden-description" rows="4" cols="50" required></textarea>
        </div>
        <div>
            <label for="image-upload">Image Upload:</label>
            <input type="file" id="image-upload" name="image-upload" accept="image/*" required>
        </div>
        <div>
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">I agree to the terms and conditions INSERT LINK??</label>
        </div>
        <div>
            <input type="checkbox" id="anon" name="anon">
            <label for="anonymous">Submit anonymously?</label>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    
</body>
</html>