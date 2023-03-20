    <!DOCTYPE html>
    <html>
    <head>
         <title>User</title>
    <!-- Add map library -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD93cHVgv78v7---19ZQtimRvVpqi7t_M0&callback=initMap&libraries=places&v=weekly"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="test.php"></script>
    <link rel="stylesheet" href="styles.css" class="style">

    <script>
        // Wait for the DOM to load
        document.addEventListener("DOMContentLoaded", function() {
        // Get the success message element
        var successMsg = document.getElementById("success-msg");
        // If the success message exists
        if (successMsg) {
            // Set a timeout to hide the success message after 5 seconds (5000 milliseconds)
            setTimeout(function() {
            successMsg.style.display = "none";
            }, 2000);
        }
        });         
    </script>
    <script >
    // Initialize map and marker variable
    var map;
    var marker;
    var markers = [];
    var modal = null;
    var modalContent = null;
    var openInfoWindow = null;

    function initMap() {
        // Set default map center
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 23.780372082867956, lng: 90.40712748798454
                //23.780372082867956, 90.40712748798454
            },
            zoom: 15
        });
        marker1 = new google.maps.Marker({
              position: { lat: 23.780372082867956, lng: 90.40712748798454 },
              map: map
              });

              circle = new google.maps.Circle({
              strokeColor: '#FF0000',
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: '#FF0000',
              fillOpacity: 0.25,
              map: map,
              center: marker1.getPosition(),
              radius: 20,

              });
              marker2 = new google.maps.Marker({
              position: { lat: 23.78355944048718,
                lng: 90.35578779194697 },
              map: map
              });

              circle = new google.maps.Circle({
              strokeColor: '#FF0000',
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: '#FF0000',
              fillOpacity: 0.25,
              map: map,
              center: marker2.getPosition(),
              radius: 100,

              });
              marker3 = new google.maps.Marker({
              position: { lat: 23.72857369603569,
                lng: 90.42008391561156 },
              map: map
              });

              circle = new google.maps.Circle({
              strokeColor: '#FF0000',
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: '#FF0000',
              fillOpacity: 0.25,
              map: map,
              center: marker3.getPosition(),
              radius: 100,

              });
              marker4 = new google.maps.Marker({
              position: { lat: 23.699384605092845,
                lng: 90.4525066772414 },
              map: map
              });

              circle = new google.maps.Circle({
              strokeColor: '#FF0000',
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: '#FF0000',
              fillOpacity: 0.25,
              map: map,
              center: marker4.getPosition(),
              radius: 100,

              });

                // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];

        

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
            return;
            }

            // Clear out the old markers.
            markers.forEach((marker) => {
            marker.setMap(null);
            });
            markers = [];
            
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }

            const icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25),
            };

            // Create a marker for each place.
            markers.push(
            new google.maps.Marker({
            map,
            icon,
            title: place.name,
            position: place.geometry.location,
            })
        );

        
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            });
            map.fitBounds(bounds);
        });

        
        // Create a variable to hold the locations and their coordinates
        var locations = {
            brac: {
                lat: 23.780362263720615,
                lng: 90.4072133189221
                //23.780362263720615, 90.4072133189221

            },
            kallayanpur: {
                lat: 23.78355944048718,
                lng: 90.35578779194697
                //23.78355944048718, 90.35578779194697
            },
            dcci: {
                lat: 23.72857369603569,
                lng: 90.42008391561156
                //23.72857369603569, 90.42008391561156
            },
            shonirakhra: {
                lat: 23.699384605092845,
                lng: 90.4525066772414
                //23.699384605092845, 90.4525066772414
            }
        };

        // Get the select element
        var locationSelect = document.getElementById('locationSelect');

        // Add an event listener to the select element
        locationSelect.addEventListener('change', function() {
            // Get the selected value
            var selectedValue = locationSelect.value;

            // Set the map center to the selected location
            map.setCenter(locations[selectedValue]);
        });



        var yellowMarkerIcon = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
        var iconSize = new google.maps.Size(15, 15);


        function createInfoWindow(marker) {
            var contentString = '<div><p style="color:black;">Marker type: ' + marker.marker_type + '</p>' +
                '<div><p style="color:black;">' + marker.marker_info + '</p>';

            // Close the currently open info window before opening a new one
            if (openInfoWindow) {
                openInfoWindow.close();
            }

            var infoWindow = new google.maps.InfoWindow({
                content: contentString
            });

            // Set the current info window to the newly opened one
            openInfoWindow = infoWindow;

            return infoWindow;
        }

        // Add click event listener to map
        map.addListener('click', function(event) {
            // If marker already exists, remove it from the map
            if (marker) {
                marker.setMap(null);
            }
            // Create new marker at clicked location
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map,
                title: 'New marker'
            });

            modalContent = document.createElement('div');
            modalContent.innerHTML = `
        <form method="post" action="save_marker.php" class="add-marker-form">
            <input type="hidden" id="latitude" name="latitude" value="${event.latLng.lat()}" required>
            <input type="hidden" id="status" name="status" value="pending" required>
            <input type="hidden" id="longitude" name="longitude" value="${event.latLng.lng()}" required>

            <div id="select-button" class="brd"> 
            <label for="marker_type">Marker type:</label>
                <select id="marker_type" name="marker_type" required>
                <option value="" width: 100px>Select Type</option>
                <option value="fire_station">Fire Station</option>
                <option value="fire_extinguisher">Fire Extinguisher</option>
                <option value="fire">Fire</option>
                <option value="water">Water Resource</option>
                </select>
            </div>

            <div id="marker_info">
            <input type="date" id="fire_date" name="fire_date" placeholder="Date" style="display: none;">
            <input type="time" id="fire_time" name="fire_time" placeholder="time" style="display: none;">
            <input type="text" id="casualty" name="casualty" placeholder="Casualty" style="display: none;">
            <input type="tel" id="tel" name="tel" placeholder="tel/mobile number" style="display: none;">
            <input type="text" id="qty" name="qty" placeholder="quantity" style="display: none;">
            </div>


            <input type="submit" value="Save marker">
        </form>
        `;

            // Get references to the marker type field and marker info fields
            const markerTypeField = modalContent.querySelector('#marker_type');
            const markerInfoFields = modalContent.querySelector('#marker_info');

            // Define a function to show the input fields for the selected marker type
            function showMarkerInfoFields() {
                if (markerTypeField.value === 'fire_station') {
                    markerInfoFields.querySelector('#fire_date').style.display = 'none';
                    markerInfoFields.querySelector('#fire_time').style.display = 'none';
                    markerInfoFields.querySelector('#casualty').style.display = 'none';
                    markerInfoFields.querySelector('#qty').style.display = 'none';
                    markerInfoFields.querySelector('#tel').style.display = 'block';

                } else if (markerTypeField.value === 'fire_extinguisher') {
                    markerInfoFields.querySelector('#fire_date').style.display = 'none';
                    markerInfoFields.querySelector('#fire_time').style.display = 'none';
                    markerInfoFields.querySelector('#casualty').style.display = 'none';
                    markerInfoFields.querySelector('#tel').style.display = 'none';
                    markerInfoFields.querySelector('#tel').style.display = 'block';
                    markerInfoFields.querySelector('#qty').style.display = 'block';

                } else if (markerTypeField.value === 'fire') {
                    markerInfoFields.querySelector('#tel').style.display = 'none';
                    markerInfoFields.querySelector('#qty').style.display = 'none';
                    markerInfoFields.querySelector('#fire_date').style.display = 'block';
                    markerInfoFields.querySelector('#fire_time').style.display = 'block';
                    markerInfoFields.querySelector('#casualty').style.display = 'block';

                }else if (markerTypeField.value === 'water') {
                    markerInfoFields.querySelector('#tel').style.display = 'block';
                    markerInfoFields.querySelector('#qty').style.display = 'block';
                    markerInfoFields.querySelector('#fire_date').style.display = 'none';
                    markerInfoFields.querySelector('#fire_time').style.display = 'none';
                    markerInfoFields.querySelector('#casualty').style.display = 'none';

                }
            }

            // Add an event listener to the marker type field to listen for changes
            markerTypeField.addEventListener('change', showMarkerInfoFields);

            var infoWindow = new google.maps.InfoWindow({
                content: modalContent
            });
            infoWindow.open(map, marker);
            var infoWindowOpen; // variable to keep track of info window state

            // Show info window when marker is clicked
            marker.addListener('click', function() {
                if (!infoWindowOpen) { // only open if info window is not already open
                    infoWindow.open(map, marker);
                    infoWindowOpen = true;
                }
            });

            // Close the info window when it's closed by user
            google.maps.event.addListener(infoWindow, 'closeclick', function() {
                infoWindowOpen = false;
            });


            // Set form values to clicked location
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();

            // Show form
            document.getElementById('flex-item-mid').style.display = 'flex';
            document.getElementById('success-msg').style.display = 'none';
        });


        // Create a button to show only water markers
        var waterButton = document.createElement('button');
        waterButton.textContent = 'Water';
        waterButton.addEventListener('click', function() {
            showMarkersByType('water');
        });
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(waterButton);
        // Create a button to show only fire markers
        var fireButton = document.createElement('button');
        fireButton.textContent = 'fire';
        fireButton.addEventListener('click', function() {
            showMarkersByType('fire');
        });
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(fireButton);

        // Create a button to show only fire station markers
        var fireStationButton = document.createElement('button');
        fireStationButton.textContent = 'fire station';
        fireStationButton.addEventListener('click', function() {
            showMarkersByType('fire_station');
        });
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(fireStationButton);

        // Create a button to show only fire extinguisher markers
        var fireExtinguisherButton = document.createElement('button');
        fireExtinguisherButton.textContent = 'fire extinguisher';
        fireExtinguisherButton.addEventListener('click', function() {
            showMarkersByType('fire_extinguisher');
        });
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(fireExtinguisherButton);

        // Create a button to show all markers
        var allMarkersButton = document.createElement('button');
        allMarkersButton.textContent = 'Show all';
        allMarkersButton.addEventListener('click', function() {
            showMarkersByType(null);
        });
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(allMarkersButton);


        // Retrieve markers from the server and add them to the map
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_markers.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var markerData = JSON.parse(xhr.responseText);
                markerData.forEach(function(marker) {
                    var iconUrl;
                    var iconSize = new google.maps.Size(40, 40);
                    if (marker.status == 'approved') {
                        if (marker.marker_type == 'fire') {
                            iconUrl = 'img/fire.png';
                        } else if (marker.marker_type == 'fire_extinguisher') {
                            iconUrl = 'img/fire-extinguisher.png';
                        } else if (marker.marker_type == 'fire_station') {
                            iconUrl = 'img/fire-station.png';
                        } 
                        else if (marker.marker_type == 'water') {
                            iconUrl = 'img/water.png';
                        }else {
                            iconUrl = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
                        }
                    } else {
                        iconUrl = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                    }
                    var newMarker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(marker.latitude),
                            lng: parseFloat(marker.longitude)
                        },
                        map: map,
                        icon: {
                            url: iconUrl,
                            scaledSize: iconSize
                        }
                    });
                    newMarker.id = marker.id;
                    newMarker.marker_info = marker.marker_info;
                    newMarker.status = marker.status;
                    newMarker.marker_type = marker.marker_type;
                    markers.push(newMarker);
                    newMarker.addListener('click', function() {
                        var infoWindow = createInfoWindow(newMarker);
                        infoWindow.open(map, newMarker);
                    });
                });

            } else {
                console.error('Error retrieving markers from server');
            }
        };
        xhr.send();


        function showMarkersByType(type) {
            markers.forEach(function(marker) {
                if ((marker.marker_type === type || type === null) && (type === null || marker.status === 'approved')) {

                    marker.setMap(map);

                } else {
                    if (marker.map !== null) {
                        marker.setMap(null);
                    }
                }
            });
        }
   
   
    }
</script>
       
</head>
    
<body onload="initMap()">
  <!-- Add map container -->
  
  <div id="map" style="height: 800px;"></div>
  
  <select id="locationSelect">
    <option value="" width: 100px>location</option>
    <option value="brac">BRAC University</option>
    <option value="kallayanpur">Kallayanpur</option>
    <option value="dcci">DCCI</option>
    <option value="shonirakhra">Shonirakhra</option>
  </select>

  <div id="nav-bx">
    <span id="add-marker-msg"> Click on the map to add new marker! </span>;
  </div>

  <!-- <form action="#"><input type="search" placeholder="Seach..."><i class="fa fa-search"></i></form> -->
  <div id="search-bar">
   
      <input id="pac-input" type="search" class="controls" placeholder="Search Box" required>
      
    
  </div> 

  <?php
    if (isset($_GET['msg'])) {
    echo "
    <div id='success-msg'>
    Success! Waiting for Approval.
    </div>";
    }
   ?>
</body>
</html>
