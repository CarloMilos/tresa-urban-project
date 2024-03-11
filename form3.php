<?php
require 'config.php';

    $tresacords = json_encode($tresaCoords)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRESA Resident Input Form</title>
    <link rel="stylesheet" type="text/css" href="formstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto" rel="stylesheet">
    <style>
        body {
    font-family: 'Open Sans', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.form_container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 40px;
    margin: 50px auto;
    max-width: 600px;
}

.title {
    text-align: center;
    margin-bottom: 20px;
}

.title h1 {
    color: #073b38;
    font-weight: 600;
}

.title h3 {
    color: #333;
    font-weight: 400;
}

label {
    color: #333;
    font-weight: 600;
}

input[type="text"],
input[type="email"],
textarea,
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Ensure padding and border don't affect the width */
}

input[type="checkbox"] {
    margin-right: 5px;
}

button[type="submit"] {
    background-color: #073b38;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0d6efd;
}
    </style>
     
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATR9HPYozaZE1YdlI1b7Fn_k34TtRXzLg&libraries=geometry"></script>
    <script>
        var formMap;
        var marker;
        var bristolLine;

        function initFormMap() {
            formMap = new google.maps.Map(document.getElementById('formMap'), {
                center: {lat: 51.4421635, lng: -2.5773008},
                zoom: 15
            });

            // Define the coordinates for the line around Bristol
            var bristolCoords = <?php echo $tresacords ?>

            // Construct the line
            bristolLine = new google.maps.Polyline({
                path: bristolCoords,
                geodesic: true,
                strokeColor: '#073b38',
                strokeOpacity: 0.8,
                strokeWeight: 2
            });

            // Set line on the map
            bristolLine.setMap(formMap);

            // Listen for clicks on the map to drop a marker
                        google.maps.event.addListener(formMap, 'click', function(event) {
                if (google.maps.geometry.poly.containsLocation(event.latLng, bristolLine)) {
                    placeMarker(event.latLng);
                } else {
                    alert("Please place the marker within the established area.");
                }
            });
        }

        function placeMarker(location) {
            if (marker) {
                marker.setMap(null); // Remove previous marker
            }
            marker = new google.maps.Marker({
                position: location,
                map: formMap
            });

            // Update hidden inputs with marker data
            document.getElementById('latitude').value = location.lat();
            document.getElementById('longitude').value = location.lng();

            // Show the remove button
            document.getElementById('removeButton').style.display = 'block';
        }

        function removeMarker() {
            marker.setMap(null); // Remove the marker from the map
            marker = null; // Reset marker variable
            document.getElementById('removeButton').style.display = 'none'; // Hide the remove button
            document.getElementById('latitude').value = ''; // Clear latitude input
            document.getElementById('longitude').value = ''; // Clear longitude input
        }

    </script>
    <script>
    function handleFormSubmission(event) {
        if (!marker) {
            alert("Please place a marker on the map before submitting the form.");
            event.preventDefault(); // Prevent form submission
        }
    }
</script>

</head>
<body onload="initFormMap()">
<div class="form_container">
    <div class="title">
        <h1> TRESA Urban Nature Reserve Input Form <h1>
        <h3> Completing this form will input your information regarding you Nature Reserve  into the TRESA Urban Nature Reserve Database</h3>
    </div>
    <form action="formpost1.php" method="POST" enctype="multipart/form-data" onsubmit="handleFormSubmission(event)">

        <div>
            <label for="uname">Name:</label>
            <input type="text" id="uname" name="uname" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <label for="mapinputs">Please place a Marker on the location of your Nature Reserve</label>
            <div id="formMap" style="height: 350px; width: 100%;"></div>
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        <div>
            <input type="button" id="removeButton" value="Remove Marker" style="display: none;" onclick="removeMarker()">
        </div>
        <div>
            <label for="garden-description">Garden Description:</label><br>
            <textarea id="garden-description" name="garden-description" rows="4" cols="50" required></textarea>
        </div>
        <div>
            <label for="dimensions">Dimensions:</label>
            <input type="number" id="dimensions" name="dimensions" required>
            <span>m<sup>2</sup></span>
        </div>
        <div>
            <label for="categories">Categories:</label><br>
        </div>
        <div id="categoriesDropdown">
            <div class="checkbox-wrapper">
                <label for="trees">Trees</label>
                <input type="checkbox" id="trees" name="categories[]" value="trees">
            </div>
            <div class="checkbox-wrapper">
                <label for="flowers">Flowers</label>
                <input type="checkbox" id="flowers" name="categories[]" value="flowers">
            </div>
            <div class="checkbox-wrapper">
                <label for="hedges">Hedges</label>
                <input type="checkbox" id="hedges" name="categories[]" value="hedges">
            </div>
            <div class="checkbox-wrapper">
                <label for="birds">Birds</label>
                <input type="checkbox" id="birds" name="categories[]" value="birds">
            </div>
            <div class="checkbox-wrapper">
                <label for="insects">Insects</label>
                <input type="checkbox" id="insects" name="categories[]" value="insects">
            </div>
        </div>
        <div>
            <label for="image-upload">Image Upload:</label>
            <input type="file" id="image-upload" name="image-upload" accept="image/*">
        </div>
        <div>
        <label for="terms">I agree to the <a href="INSERT LINK">terms and conditions</a>:</label>
        <input type="checkbox" id="terms" name="terms" required>
        </div>
        <div>
            <h4 class="anontype">If you would like to opt out of having your data added to the map, tick the box below!</h4>
            <label for="anon">
                <input type="checkbox" id="anon" name="anon">Submit anonymously?
            </label>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
</body>
</html>
