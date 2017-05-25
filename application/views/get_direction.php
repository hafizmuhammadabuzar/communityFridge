<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Community Fridge - Direction</title>
        
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            #map-canvas {
                height: 100%;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div id="map-canvas"></div>        
    </body>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDvM91-7P1Vm9CvI1jwygRn8budCXu2hP8"></script>
        <script type="text/javascript">
            function initMap() {
                var pointA = new google.maps.LatLng(parseFloat(<?php echo $_GET['sLat']; ?>),parseFloat(<?php echo $_GET['sLng']; ?>)),
                    pointB = new google.maps.LatLng(parseFloat(<?php echo $_GET['eLat']; ?>),parseFloat(<?php echo $_GET['eLng']; ?>)),
                    myOptions = {
                        zoom: 7,
                        center: pointA
                    },
                    map = new google.maps.Map(document.getElementById('map-canvas'), myOptions),
                    // Instantiate a directions service.
                    directionsService = new google.maps.DirectionsService,
                    directionsDisplay = new google.maps.DirectionsRenderer({
                        map: map
                    }),
                    markerA = new google.maps.Marker({
                        position: pointA,
                        title: "Starting Point",
                        map: map
                    }),
                    markerB = new google.maps.Marker({
                        position: pointB,
                        title: "Ending Point",
                        map: map
                    });

                // get route from A to B
                calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
            }

            function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
                directionsService.route({
                    origin: pointA,
                    destination: pointB,
                    avoidTolls: true,
                    avoidHighways: false,
                    travelMode: google.maps.TravelMode.DRIVING
                }, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            }

            initMap();
        </script>
</html>