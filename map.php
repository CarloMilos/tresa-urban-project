<?php
    // Include the config file
    require 'config.php';

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

    // Initialise variable to store total public area
    $totalPublicArea = 0;
    // Loop through $publicmarkers array, grab the dimens and add to $totalPublicArea
    if(is_array($publicmarkers) || is_object($publicmarkers)){

        foreach($publicmarkers as $publicmarker){
            $totalPublicArea += $publicmarker['dimens'];
        }
    }

    // Encode the markers array into JSON
    $publicmarkers = json_encode($publicmarkers);

    // Array to store marker data
    $privateMarkerData = array();

    // Fetch locations from the Private_Greenspaces table
    $sql2 = "SELECT 
    pp.post_resident_name,
    pp.post_lat,
    pp.post_long,
    pp.post_desc,
    pp.post_dimens,
    pp.post_image,
    pp.post_anon,
    pp.validated,
    GROUP_CONCAT(c.category_name SEPARATOR ', ') AS categories
    FROM 
        privatespace_post pp
    LEFT JOIN 
        category_has_post chp ON pp.post_id = chp.FK_post_id
    LEFT JOIN 
        category c ON chp.FK_category_id = c.category_id
    WHERE validated = 1
    GROUP BY 
        pp.post_id;
    ;";

    // Execute the query
    $stmt2 = $pdo->query($sql2);

    // Fetching data row by row
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        // Add each row as a marker to the markers array
        $privateMarkerData[] = array(
            'name' => $row['post_resident_name'],
            'lat' => $row['post_lat'],
            'lng' => $row['post_long'],
            'desc'=> $row['post_desc'],
            'dimensions' => $row['post_dimens'],
            'categories' => $row['categories'],
        );
    }

    // Initialise variable to store total private area
    $totalPrivateArea = 0;
    // Loop through $privateMarkerData array, grab the dimens and add to $totalPrivateArea
    if(is_array($privateMarkerData) || is_object($privateMarkerData)){

        foreach($privateMarkerData as $privateMarker){
            $totalPrivateArea += $privateMarker['dimensions'];
        }
    }

    // TRESA area size in square metres
    $tresaSize = 357000;

    // Calculate the remaining area
    $remainingArea = $tresaSize - $totalPublicArea - $totalPrivateArea;

    // Encode the markers array into JSON
    $privateMarkerData = json_encode($privateMarkerData);

    ?>

<!DOCTYPE html>
<html>
    <title>Place and Remove Public Green Space Marker</title>
    <?php echo $api_key; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
    
    // Initialise variables

    // Map variable
    var map;
    // Array for public green spaces polygons
    var polygons = [];
    // Array for public green space markers
    var publicMarkers = [];
    // Array for public green space marker data
    var publicMarkerData = <?php echo $publicmarkers; ?>;
    // Array for private green space marker data
    var privateMarkerData = <?php echo $privateMarkerData; ?>;
    // Array for private green space markers
    var privateMarkers = [];
    // Initialise coordinates from config file as JS variables
    var tresaCoords = <?php echo $tresaCoords; ?>;
    var areas = <?php echo $areas; ?>;

    // Create infoWindow variable so that only one infoWindow is open at a time
    var infoWindow = new google.maps.InfoWindow();
    
    // Marker icon
    var green = 'https://icons8.com/icon/20873/organic-food';

    // Initialise TRESA area map
    function initMap() {

        // Create a new map, center is co-ords in the middle of the TRESA area
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.44148754688007, lng: -2.576942891944935},
            zoom: 16
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

        // Loops through the areas array and draws the polygons (public spaces) on the map
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
        for (var i = 0; i < privateMarkerData.length; i++) {
            addprivateMarkerData(privateMarkerData[i]);
        }
    }

    // Highlights area
    function highlightArea(i){
        polygons[i].setOptions({fillColor: '#ff0000'});
    }

    // Unhighlights area
    function unhighlightArea(i){
        polygons[i].setOptions({fillColor: '#4ff77c'});
    }

    // Function to open infoWindow on public markers
    function clickArea(i){
        google.maps.event.trigger(publicMarkers[i], 'click');
    }

    // Function to open infoWindow on private markers
    function clickPrivateMarker(i){
        google.maps.event.trigger(privateMarkers[i], 'click');
    }
 
    // Function to add a marker to the map
    function addMarker(markerInfo) {
        // Initialise marker variable
        var marker;
        
        // Create a new marker
        marker = new google.maps.Marker({
            position: { lat: parseFloat(markerInfo.lat), lng: parseFloat(markerInfo.lng) },
            map: map,
            icon: {
                url: 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png', // URL of your marker image
                scaledSize: new google.maps.Size(32, 32) // Adjust the size as needed
            }
        });

        // Add the marker to the publicMarkers array
        publicMarkers.push(marker);

        // Add click event listener to the regular marker
        marker.addListener('click', function() {
            var contentString = '<div>' +
                '<p>Name: ' + markerInfo.Name + '</p>' +
                '<p>Description: ' + markerInfo.desc + '</p>' +
                '<p>Size: ' + markerInfo.dimens + ' m²</p>' +
                '</div>';
            infoWindow.setContent(contentString);
            infoWindow.open(map, marker);
            infoWindow.focus();
        });

        // Add the marker to the map
        return marker;
    }

    // Function to add a private marker to the map
    function addprivateMarkerData(markerInfo) {
        // Initialise marker variable
        var marker;

        // Create a new marker
        marker = new google.maps.Marker({
            position: { lat: parseFloat(markerInfo.lat), lng: parseFloat(markerInfo.lng) },
            map: map
        });

        // Add the marker to the privateMarkers array
        privateMarkers.push(marker);

        // Add click event listener to the private marker
        marker.addListener('click', function() {
            var contentString = '<div>' +
                '<p>Name: ' + markerInfo.name + '</p>' +
                '<p>Description: ' + markerInfo.desc + '</p>' +
                '<p>Size: ' + markerInfo.dimensions + ' m²</p>' +
                '</div>';
            infoWindow.setContent(contentString);
            infoWindow.open(map, marker);
            infoWindow.focus();
        });

        // Add the private marker to the map
        return marker;
    }

</script>
<style>

    body{
        cursor: default;
    }

    /* Set table hover colour */
    tr:hover {background-color: #df988b;}
</style>
</head>
<body onload="initMap()">

    <!-- Container for the map and the list of public and private green spaces -->
    <div class="container-fluid">

        <div class="row">

            <!-- Map -->
            <div class="col w-50 p-3 m-3 border border-dark rounded justify-content-center">
            
                <h3>Totterdown Urban Nature Reserve</h3>
                <div id="map" class="border border-dark rounded" style="height: 800px; width: 100%;"></div>

            </div>

            <!-- List of public and private green spaces -->
            <div class="col w-50 p-3 m-3 border border-dark rounded">

                <!-- Tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="public-tab" data-bs-toggle="tab" href="#public" role="tab" aria-controls="public" aria-selected="true">Public Green Spaces</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="private-tab" data-bs-toggle="tab" href="#private" role="tab" aria-controls="private" aria-selected="false">User Submitted Green Spaces</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="analytics-tab" data-bs-toggle="tab" href="#analytics" role="tab" aria-controls="private" aria-selected="false">Analytics</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="form3.php" role="tab">Submission Form</a>
                    </li>
                </ul>
                
                <!-- Tab content -->
                <div class="tab-content p-2" id="greenspacesTabsContent" style="max-height: 800px; overflow: auto;">

                    <!-- Public green spaces -->
                    <div class="tab-pane fade show active" id="public" role="tabpanel" aria-labelledby="public-tab">
                        <table class="table-responsive" id="publicTable">
                            <!-- Table header -->
                            <thead>
                                <tr style="pointer-events: none">
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Size (m²)</th>
                                    <th>Image</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                <?php
                                    
                                    // Connect to the database
                                    $query = $pdo->query('SELECT * FROM publicspace_post');
                                    // Fetch the results
                                    $results = $query->fetchAll();

                                    // Loop through the results and display them in the table
                                    for ($i = 0; $i < count($results); $i++) {
                                        $tresa_db = $results[$i];

                                        echo '<tr onmouseover="highlightArea('.$i.')" onmouseout="unhighlightArea('. $i .')"  onclick="clickArea('.$i.')">';
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

                    <!-- Private green spaces -->
                    <div class="tab-pane fade" id="private" role="tabpanel" aria-labelledby="private-tab" style="max-height: 800px; overflow: auto;">
                        <table class="table-responsive" id="publicTable">
                            <!-- Table header -->
                            <thead>
                                <tr style="pointer-events: none">
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Size (m²)</th>
                                    <th>Categories(s)</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                                    
                            <!-- Table body -->
                            <tbody>

                                <?php

                                    // SQL query to select all private green spaces, and the category/s they belong to
                                    $sql = "SELECT pp.*, c.category_name
                                    FROM privatespace_post pp
                                    INNER JOIN category_has_post chp ON pp.post_id = chp.FK_post_id
                                    INNER JOIN category c ON chp.FK_category_id = c.category_id";

                                    // Execute the query and fetch the results
                                    $resultsPrivate = $pdo->query($sql);

                                    // Loop through the results and display them in the table
                                    foreach ($resultsPrivate as $private_greenspace) {
                                        echo '<tr onclick="clickPrivateMarker('.$private_greenspace['post_id'].')">';
                                        echo '<td>' . $private_greenspace['post_id'] . '</td>';
                                        echo '<td>' . $private_greenspace['post_desc'] . '</td>';
                                        echo '<td>' . $private_greenspace['post_dimens'] . '</td>';
                                        echo '<td>' . $private_greenspace['category_name'] . '</td>';
                                        echo '<td><img src="' . $private_greenspace['post_image'] . '" alt="Image" style="max-width: 200px"></td>';
                                        echo '</tr>';
                                    }
                                    
                                    


                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Analytics -->
                    <div class="tab-pane fade" id="analytics" role="tabpanel" aria-labelledby="analytics-tab" style="max-height: 800px; overflow: auto;" onload="createChart()">
                    
                    <!-- Chartholder -->
                    <div>
                        <canvas id="pie-chart" style="width:100%;"></canvas>
                    </div>

                        <script>
                            // Gather chart data
                            const xValues = ["Public Areas", "User Submissions", "Remaining Totterdown Area"];
                            const yValues = [<?php echo $totalPublicArea ?>, <?php echo $totalPrivateArea ?>, <?php echo $remainingArea ?>];
                            // Chart colors
                            const barColors = [
                                "#66d15f",
                                "#0d6efd",
                                "#818282"
                            ];

                            // Create chart
                            var ctx = document.getElementById("pie-chart").getContext("2d");
                            new Chart(ctx, {
                                type: "pie",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                    }]
                                },
                                options: {
                                    title: {
                                    display: true,
                                    text: "Totterdown Urban Nature Reserve Area Distribution"
                                    },
                                    tooltips: {
                                        callbacks: {
                                        label: function(tooltipItem, data) {
                                            var dataset = data.datasets[tooltipItem.datasetIndex];
                                            var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                                            var total = meta.total;
                                            var currentValue = dataset.data[tooltipItem.index];
                                            var percentage = parseFloat((currentValue/total*100).toFixed(1));
                                            return currentValue + 'm² (' + percentage + '%)';
                                        },
                                        title: function(tooltipItem, data) {
                                            return data.labels[tooltipItem[0].index];
                                        }
                                        }
                                    },
                                }
                            });
                        </script>
                        
                    </div>

                </div>
                             
            </div>

        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>