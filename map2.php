<?php
    // Include the config file
    require 'config.php';

    require 'dbcon2.php'; // This file should contain your database connection code

    // Get TRESA area coordinates from the config file and turn into JSON array
    $tresaCoords = json_encode($tresaCoords);

    // Get public green space areas coordinates from the config file and turn into JSON array
    $areas = json_encode($areas);

    $publicmarkers = array(); // Array to store all markers data
    
    // Fetch locations from the Public_Greenspaces table
    $sql = "SELECT * FROM publicspace_post";
    $stmt = $pdo->query($sql);

    // Fetching data row by row for public greenspaces
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add each row as a marker to the markers array
        $publicmarkers[] = array(
            'Name' => $row['post_area_name'],
            'lat' => $row['post_lat'],
            'lng' => $row['post_long'],
            'desc' => $row['post_desc'],
            'dimens' => $row['post_dimens'],
            'image' => $row['post_image'],
        );
    }
$publicmarkers = json_encode($publicmarkers);
    // Encode the markers array into JSON
    $privatemarkers = array(); // Array to store marker data

    $sql2 = "SELECT post_resident_name, post_lat, post_long, post_desc, post_dimens, post_image, post_anon, GROUP_CONCAT(category_name) AS categories FROM privatespace_post JOIN category_has_post ON privatespace_post.post_id = category_has_post.FK_post_id JOIN category ON category_has_post.FK_category_id = category.category_id;";

        $stmt2 = $pdo->query($sql2);

        // Fetching data row by row
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            // Add each row as a marker to the markers array
            $privatemarkers[] = array(
                'name' => $row['post_resident_name'],
                'lat' => $row['post_lat'],
                'lng' => $row['post_long'],
                'desc'=> $row['post_desc'],
                'dimensions' => $row['post_dimens'],
                'categories' => $row['categories'],
            );
        }

            // Encode the markers array into JSON
            $privatemarkers = json_encode($privatemarkers);
    ?>

<!DOCTYPE html>
<html>
    <title>Place and Remove Public Green Space Marker</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATR9HPYozaZE1YdlI1b7Fn_k34TtRXzLg&libraries=geometry"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script>
    var map;
    var polygons = [];
    var publicMarkerData = <?php echo $publicmarkers; ?>; // Retrieve marker data from PHP
    var privatemarkers = <?php echo $privatemarkers; ?>;
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

        }

        // Add markers to the map
        for (var i = 0; i < publicMarkerData.length; i++) {
            addMarker(publicMarkerData[i]); // Corrected function call
        }

            // Add private markers to the map
        for (var i = 0; i < privatemarkers.length; i++) {
            addPrivateMarker(privatemarkers[i]);
        }
    }

    function highlightArea(i){
        polygons[i].setOptions({fillColor: '#ff0000'});
    }

    function unhighlightArea(i){
        polygons[i].setOptions({fillColor: '#4ff77c'});
    }
 
    function addMarker(markerInfo) {
        var marker;
        
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
                    '<p>Name: ' + markerInfo.Name + '</p>' +
                    '<p>Description: ' + markerInfo.desc + '</p>' +
                    '<p>Size: ' + markerInfo.dimens + ' m²</p>' +
                    '</div>';
                infoWindow.setContent(contentString);
                infoWindow.open(map, marker);
            });

        // Add the marker to the map
        return marker;
    }
    function addPrivateMarker(markerInfo) {
    var marker;

    marker = new google.maps.Marker({
        position: { lat: parseFloat(markerInfo.lat), lng: parseFloat(markerInfo.lng) },
        map: map
    });

    // Add click event listener to the private marker
    marker.addListener('click', function() {
        var contentString = '<div>' +
            '<p>Name: ' + markerInfo.name + '</p>' +
            '<p>Description: ' + markerInfo.desc + '</p>' +
            '<p>Size: ' + markerInfo.dimensions + ' m²</p>' +
            '</div>';
        infoWindow.setContent(contentString);
        infoWindow.open(map, marker);
    });

    // Add the private marker to the map
    return marker;
}


</script>
<style>
    body{
        cursor: default;
    }
</style>
</head>
<body onload="initMap()">


    <div class="container-fluid">

        <div class="row">

            <div class="col w-50 p-3 m-3 border border-dark rounded justify-content-center">
            
                <h3>Totterdown Urban Nature Reserve</h3>
                <div id="map" class="border border-dark rounded" style="height: 800px; width: 100%;"></div>

            </div>

            <div class="col w-50 p-3 m-3 border border-dark rounded">

                
                
                <ul class="nav nav-tabs">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="public-tab" data-bs-toggle="tab" href="#public" role="tab" aria-controls="public" aria-selected="true">Public Green Spaces</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="private-tab" data-bs-toggle="tab" href="#private" role="tab" aria-controls="private" aria-selected="false">User Submitted Green Spaces</a>
                    </li>
                </ul>

                

                <div class="tab-content p-2" id="greenspacesTabsContent" style="max-height: 800px; overflow: auto;">
                    <div class="tab-pane fade show active" id="public" role="tabpanel" aria-labelledby="public-tab">
                        <table class="table-responsive" id="publicTable">'
                            <thead>
                                <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Size (m²)</th>
                                <th>Image</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    
                                    $query = $pdo->query('SELECT * FROM publicspace_post');
                                    $results = $query->fetchAll();

                                    for ($i = 0; $i < count($results); $i++) {
                                        $tresa_db = $results[$i];

                                        echo '<tr onmouseover="highlightArea('.$i.')" onmouseout="unhighlightArea('. $i .')">';
                                        echo '<td>' . $tresa_db['post_area_name'] . '</td>';
                                        echo '<td>' . $tresa_db['post_desc'] . '</td>';
                                        echo '<td>' . $tresa_db['post_dimens'] . '</td>';
                                        
                                        if (!empty($tresa_db['Image'])) {
                                            echo '<td><img src="' . $tresa_db['Image'] . '" alt="Image" style="max-width: 200px"></td>';
                                        } else {
                                            echo '<td>No image available</td>';
                                        }

                                        echo '</tr>';
                                    }

                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="private" role="tabpanel" aria-labelledby="private-tab" style="max-height: 800px; overflow: auto;">
                        <?php
                            // Code to fetch and display data from the private_greenspaces table
                            foreach($pdo->query('SELECT * FROM private_greenspaces') as $private_greenspace){
                                echo '<table class="table-responsive">';
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
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td>'.$private_greenspace['ID'].'</td>';
                                echo '<td>'.$private_greenspace['Name'].'</td>';
                                echo '<td>'.$private_greenspace['Type'].'</td>';
                                echo '<td>'.$private_greenspace['Location'].'</td>';
                                echo '<td>'.$private_greenspace['Size'].'</td>';
                                echo '<td>'.$private_greenspace['Description'].'</td>';
                                echo '<td>'.$private_greenspace['DateEstablished'].'</td>';
                                echo '<td>'.$private_greenspace['Lat'].'</td>';
                                echo '<td>'.$private_greenspace['Long'].'</td>';
                                echo '<td><img src="'.$private_greenspace['Image'].'" alt="Image"></td>';
                                echo '</tr>';
                                echo '</table>';
                            }
                        ?>
                    </div>

                </div>
                             
            </div>

        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>