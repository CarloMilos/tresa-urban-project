<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRESA Resident Input Form</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATR9HPYozaZE1YdlI1b7Fn_k34TtRXzLg&libraries=geometry"></script>
    <script>
        var map;
        var marker;
        var bristolZone;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 51.4421635, lng: -2.5773008},
                zoom: 15
            });

            // Define the coordinates for the zone around Bristol
            var bristolCoords = []

            // Construct the polygon
            bristolZone = new google.maps.Polygon({
                paths: bristolCoords,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });

            // Set polygon on the map
            bristolZone.setMap(map);

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(location) {
            if (marker) {
                marker.setMap(null); // Remove previous marker
            }
            marker = new google.maps.Marker({
                position: location,
                map: map
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
    <script>
    function handleImageUpload() {
        var imageUpload = document.getElementById('image-upload');
        var socialMediaDiv = document.getElementById('social-media-dropdown');
        var instagramUserDiv = document.getElementById('instagram-user-div');

        if (imageUpload.value) {
            socialMediaDiv.style.display = 'block';
            instagramUserDiv.style.display = 'block';
        } else {
            socialMediaDiv.style.display = 'none';
            instagramUserDiv.style.display = 'none';
        }
    }
</script>

</head>
<body onload="initMap()">
    <div class="title">
        <h1> TRESA Urban Nature Reserve Input Form <h1>
    </div>
    <form action="formpost1.php" method="POST" enctype="multipart/form-data" onsubmit="handleFormSubmission(event)">

        <div>
            <label for="uname">Name:</label>
            <input type="text" id="name" name="uname" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <label for="mapinputs">Please place a Marker on the location of your Nature Reserve</label>
        <div id="map" style="height: 350px; width: 80%;"></div>
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
            <select name="unit">
                <option value="cm2">cm<sup>2</sup></option>
                <option value="m2">m<sup>2</sup></option>
            </select>
        </div>
        <div>
            <label for="categories">Categories:</label><br>
            <input type="checkbox" id="trees" name="categories[]" value="trees">
            <label for="trees">Trees</label><br>
            <input type="checkbox" id="flowers" name="categories[]" value="flowers">
            <label for="flowers">Flowers</label><br>
            <input type="checkbox" id="hedges" name="categories[]" value="hedges">
            <label for="hedges">Hedges</label><br>
            <input type="checkbox" id="birds" name="categories[]" value="birds">
            <label for="birds">Birds</label><br>
            <input type="checkbox" id="insects" name="categories[]" value="insects">
            <label for="insects">Insects</label><br>
        </div>
        <div>
        <label for="image-upload">Image Upload:</label>
        <input type="file" id="image-upload" name="image-upload" accept="image/*" onchange="handleImageUpload()">
        </div>
        <div id="social-media-dropdown" style="display: none;">
            <label for="social-media-permission">Can we upload the photo for social media purposes (Instagram, Twitter, Facebook)?</label>
            <select name="social-media-permission" required>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>
        <div id="instagram-user-div" style="display: none;">
            <label for="instagram-user-input">Instagram Username (So We Can Tag You!)</label>
            <input type="text" id="instagram-user-input" name="instagram-user" >
        </div>

            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">I agree to the terms and conditions INSERT LINK??</label>
        </div>
        <div>
            <h5> If you would like to opt out of having your data added to the map, tick the box below!</h5>
            <input type="checkbox" id="anon" name="anon">
            <label for="anonymous">Submit anonymously?</label>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>
