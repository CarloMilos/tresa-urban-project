<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<?php
    // Include the config file
    require 'config.php';

    require 'dbcon.php'; // This file should contain your database connection code

    // Get TRESA area coordinates from the config file and turn into JSON array
    $tresaCoords = json_encode($tresaCoords);

    // Get public green space areas coordinates from the config file and turn into JSON array
    $areas = json_encode($areas);

    $markers = array(); // Array to store all markers data
    
echo '<table>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Name</th>';
echo '<th>Type</th>';
echo '<th>Location</th>';
echo '<th>Size</th>';
echo '<th>Description</th>';
echo '<th>DateEstablished</th>';
echo '<th>Lat</th>';
echo '<th>Long</th>';
echo '<th>Image</th>';
echo '<th>IconPath</th>';

echo '</tr>';
foreach($pdo->query('SELECT * FROM public_greenspaces') as $tresa_db){
    echo '<tr>';
    echo '<td>'.$tresa_db['ID'].'</td>';
    echo '<td>'.$tresa_db['Name'].'</td>';
    echo '<td>'.$tresa_db['Type'].'</td>';
    echo '<td>'.$tresa_db['Location'].'</td>';
    echo '<td>'.$tresa_db['Size'].'</td>';
    echo '<td>'.$tresa_db['Description'].'</td>';
    echo '<td>'.$tresa_db['DateEstablished'].'</td>';
    echo '<td>'.$tresa_db['Lat'].'</td>';
    echo '<td>'.$tresa_db['Long'].'</td>';
    echo '<td><img src="'.$tresa_db['Image'].'" alt="Image"></td>'; // Display image
    
}
echo '</table>';

    

    // Fetch locations from the Public_Greenspaces table
    $sql = "SELECT * FROM Public_Greenspaces";
    $stmt = $pdo->query($sql);

    // Fetching data row by row for public greenspaces
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add each row as a marker to the markers array
        $markers[] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'lat' => $row['Lat'],
            'lng' => $row['Long'],
            'desc' => $row['Description'],
            'location' => $row['Location'],
            'type' => $row['Type'], // Assuming 'Type' represents the category of the green space
            'size' => $row['Size'],
            'icon' => $row['IconPath'], // Include IconPath for public greenspaces
            'category' => 'greenspace' // Additional field to distinguish between public greenspaces and wildlife markers
        );
    }

    // Fetch locations from the wildlife table
    $sql = "SELECT * FROM wildlife";
    $stmt = $pdo->query($sql);

    // Fetching data row by row for wildlife
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add each row as a marker to the markers array
        $markers[] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Category' => $row['Category'],
            'lat' => $row['Wildlife_lat'], // Updated column name
            'lng' => $row['Wildlife_long'], // Updated column name
            'icon' => $row['IconPath'],
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
    
    var green = 'https://icons8.com/icon/20873/organic-food';

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
 
function addMarker(markerInfo) {
    var marker;
    


    // Check if the marker is a wildlife marker
    if (markerInfo.Category === 'wildlife') {
        var wildlifeIcon = {
            url: markerInfo.icon,
            scaledSize: new google.maps.Size(32, 32),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(16, 16)
        };

        // Create a wildlife marker
    marker = new google.maps.Marker({
        position: { lat: parseFloat(markerInfo.greenspaceLat), lng:     parseFloat(markerInfo.greenspaceLng) },
        map: map,
        icon: 'https://cdn4.iconfinder.com/data/icons/zoo-17/60/zoo__location__navigation__wild__map-512.png' // URL of your wildlife marker icon
});

        // Add click event listener to the wildlife marker
        marker.addListener('click', function() {
            var contentString = '<div>' +
                '<p>ID: ' + markerInfo.ID + '</p>' +
                '<p>Name: ' + markerInfo.Name + '</p>' +
                '</div>';
            infoWindow.setContent(contentString);
            infoWindow.open(map, marker);
        });
    } else {
        // Create a regular marker
        marker = new google.maps.Marker({
            position: { lat: parseFloat(markerInfo.lat), lng: parseFloat(markerInfo.lng) },
            map: map,
            icon: {
                url: 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png', // URL of your marker image
                scaledSize: new google.maps.Size(32, 32) // Adjust the size as needed
            }
        });

        // Add click event listener to the regular marker
        marker.addListener('click', function() {
            var contentString = '<div>' +
                '<p>ID: ' + markerInfo.ID + '</p>' +
                '<p>lat: ' + markerInfo.lat + '</p>' +
                '<p>long: ' + markerInfo.lng + '</p>' +
                '<p>Name: ' + markerInfo.Name + '</p>' +
                '<p>Location: ' + markerInfo.location + '</p>' +
                '<p>Size: ' + markerInfo.size + '</p>' +
                '<p>Type: ' + markerInfo.type + '</p>' +
                '</div>';
            infoWindow.setContent(contentString);
            infoWindow.open(map, marker);
        });
    }

    // Add the marker to the map
    return marker;
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

</body>
</html>