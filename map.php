<?php
    // Include the config file
    require 'config.php';

    require 'dbcon.php';

    //Get TRESA area coordinates from the config file and turn into JSON array
    $tresaCoords = json_encode($tresaCoords);

    //Get public green space areas coordinates from the config file and turn into JSON array
    $areas = json_encode($areas);

    $markers = array(); // Array to store marker data

    $sql = "SELECT * FROM post"; // Replace 'your_table' with your actual table name
    $stmt = $pdo->query($sql);

    // Fetching data row by row
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add each row as a marker to the markers array
        $markers[] = array(
            'lat' => $row['post_lat'],
            'lng' => $row['post_long'],
            'desc'=> $row['post_desc'],
            'dimensions' => ['post_dimens'],
        );
    }

        // Encode the markers array into JSON
        $markers = json_encode($markers);
?>
<style>
    <?php include 'styles.css'; ?>
</style>    

<!DOCTYPE html>
<html>
    <title>Place and Remove Public Green Space Marker</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATR9HPYozaZE1YdlI1b7Fn_k34TtRXzLg&libraries=geometry"></script>
    <script>
        var map;
        var polygons = [];
        var markersData = <?php echo $markers; ?>; // Retrieve marker data from PHP


        // Initialise coordinates from config file as JS variables
        var tresaCoords = <?php echo $tresaCoords; ?>;
        var areas = <?php echo $areas; ?>;

        // Create infoWindow variable so that only one infoWindow is open at a time
        var infoWindow = new google.maps.InfoWindow();

        // Initialise TRESA area map
        function initMap() {

            // Create a new map, center is co-ords in the middle of the TRESA area
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 51.44148754688007, lng: -2.576942891944935},
                zoom: 15
            });

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });

            // Draw TRESA area on the map
            tresaArea = new google.maps.Polyline({
                path: tresaCoords,
                geodesic: true,
                strokeColor: '#073b38',
                strokeOpacity: 0.8,
                strokeWeight: 2
            });

            // Set TRESA area on the map
            tresaArea.setMap(map);

            
            // Loops through the areas array and draws the polygons on the map
            for(let i = 0; i<Object.keys(areas).length; i++){
                
                //Draws polygon i on the map
                polygons[i] = new google.maps.Polygon({
                    paths: areas[i],
                    strokeColor: '#00ff44',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#4ff77c',
                    fillOpacity: 0.35
                });

                // Set polygon i on the map
                polygons[i].setMap(map);
                
                // Add click event listener to the polygon, so that when clicked, an infoWindow opens
                google.maps.event.addListener(polygons[i], 'click', function(event) {
                        var size = google.maps.geometry.spherical.computeArea(polygons[i].getPath());
                        var contentString = 'You clicked on the polygon at ' + event.latLng + '<br>Area: ' + size + ' m<sup>2</sup>';
                        infoWindow.setContent(contentString);
                        infoWindow.setPosition(event.latLng);
                        infoWindow.open(map);
                
                });
            }
            // Add markers to the map
            for (var i = 0; i < markersData.length; i++) {
                addMarker(markersData[i]);
            }
            
        }

        

        function placeMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            // Add the marker to the array
            markers.push(marker);

            // Update hidden inputs with marker data
            document.getElementById('latitude').value = location.lat();
            document.getElementById('longitude').value = location.lng();

            // Show the remove button
            document.getElementById('removeButton').style.display = 'block';

            // Show the form for entering additional details
            document.getElementById('markerDetailsForm').style.display = 'block';

            // Add click event listener to the marker
            marker.addListener('click', function() {
                showRemoveButton(marker);
            });
        }

        function showRemoveButton(marker) {
            var removeButton = document.getElementById('removeButton');
            removeButton.style.display = 'block';
            removeButton.onclick = function() {
                removeMarker(marker);
            };
        }

        function removeMarker(marker) {
            marker.setMap(null); // Remove the marker from the map
            var index = markers.indexOf(marker);
            if (index > -1) {
                markers.splice(index, 1); // Remove the marker from the array
            }
            document.getElementById('removeButton').style.display = 'none'; // Hide the remove button
            document.getElementById('markerDetailsForm').style.display = 'none'; // Hide the marker details form
        }

        
    </script>
</head>
<body onload="initMap()">

        <div class="container">

            <div class="map-box">
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>

            <div class="scroll-table">
                test
            </div>

        </div>
    

    <form id="markerDetailsForm" action="handle_marker.php" method="post" style="display: none;">
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        <div>
            <label for="Name">Name:</label><br>
            <input type="text" id="name" name="name" required>

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
        <input type="submit" value="Submit">
    </form>
    <button id="removeButton" style="display: none;">Remove Marker</button>
</body>
</html>