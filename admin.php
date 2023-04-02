<?php
session_start();

if(!isset($_SESSION['adminLoggedin']) || $_SESSION['adminLoggedin']!=true){
	header("location: admin_login.php");
	exit;
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>admin</title>
  <!-- Add map library -->
  <script src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyD93cHVgv78v7---19ZQtimRvVpqi7t_M0"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css" integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
  <link rel="stylesheet" href="styles.css" class="style">
  <script src="test.js"></script>

  <script>
    // Initialize map and marker variable
    var map;
    var marker;
    var markers = []; 

function initMap() {
      // Set default map center
      // Define the map and default marker icon
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 23.780372082867956, lng: 90.40712748798454},
        zoom: 17
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

      var yellowMarkerIcon = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
      var iconSize = new google.maps.Size(15, 15);
   




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
                  }else if (marker.marker_type == 'water') {
                    iconUrl = 'img/water.png';
                  } else {
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
    // Create a button to show only water markers
    var waterButton = document.createElement('button');
    waterButton.textContent = 'Water';
    waterButton.addEventListener('click', function() {
        showMarkersByType('water');
    });

    // Create a button to show only fire markers
    var fireButton = document.createElement('button');
    fireButton.textContent = 'Fire';
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


   // Create a button to show pending requests
    var pendingButton = document.createElement('button');
    pendingButton.textContent = 'Pending Requests';
    pendingButton.addEventListener('click', function() {
        // Iterate over all markers and show only the ones that have a "pending" status
        markers.forEach(function(marker) {
            if (marker.status === 'pending') {
                marker.setMap(map);
            } else {
                if (marker.map !== null) {
                    marker.setMap(null);
                }
            }
        });
    });
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(pendingButton); 



    function createInfoWindow(marker) {
    var contentString = '<div><p style="color:black;">Marker info: ' + marker.id + '</p>';
        if (marker.status !== 'approved') {
            contentString += '<button class="popBtn" onclick="approveMarker(\'' + marker.id + '\')">Approve</button>';
        }
        contentString += '</div>';
        var infoWindow = new google.maps.InfoWindow({
            content: contentString
        });
        return infoWindow;
    }
    // Keep track of the currently open info window
        var openInfoWindow = null;
        function createInfoWindow(marker) {
            var contentString = '<div><p style="color:black;">Marker info: ' + marker.marker_info + '</p>';
            if (marker.status === 'pending') {
                contentString += '<button class="popBtn" onclick="approveMarker(\'' + marker.id + '\', this)">Approve</button>';

            } else {
                contentString += '<button class="dltBtn" onclick="deleteMarker(\'' + marker.id + '\')">Delete</button>';
            }
            contentString += '</div>';
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


	  
  }
  </script>
  <script>      




        function approveMarker(markerId, button) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'approve_marker.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                if (xhr.status === 200) {
                // The marker was approved successfully
                button.style.display = 'none';
                alert('Marker approved!');
                location.reload(); 
                document.getElementById("approvedText").style.display = "inline";
                } else {
                console.error('Error approving marker');
                }
            };
            xhr.send('marker_id=' + encodeURIComponent(markerId));
}


function deleteMarker(id) {
    if (confirm("Are you sure you want to delete this marker?")) {
        // send a DELETE request to the server to delete the marker
        var xhr = new XMLHttpRequest();
        xhr.open('DELETE', 'delete_marker.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // The marker was deleted successfully
                // Reload the page to update the markers
                alert('Deleted Successfully!');
                location.reload();
            } else {
                alert('Failed to delete marker');
            }
        };
        xhr.send('marker_id=' + id);
    }
}


 </script>

</head>
<body onload="initMap()">
  <!-- Add map container -->
  <div id="map" style="height: 800px;"></div>
  <?php
		if (isset($_GET['msg'])) {
		echo "<div id='success-msg'>
		 Success! Waiting for Approval.
		 </div>";
		}
    ?>
    <div id="nav-box">
        <a href="#">
          <img src="img/profile.webp" alt>
        </a>
        <div class="logout-popup">
          <button type="submit" class="lg-btn">
               <a href="admin_logout.php"> Log Out<i class="fa fa-sign-out"></i></a>
         </button>
        </div>
    </div>
    <select id="locationSelect">
        <option value="" width: 100px>Location</option>
        <option value="brac">BRAC University</option>
        <option value="kallayanpur">Kallayanpur</option>
        <option value="dcci">DCCI</option>
        <option value="shonirakhra">Shonirakhra</option>
    </select>

    <!-- <div id="search-bar">
        <input id="pac-input" type="search" class="controls" placeholder="Search Box" required>  
   </div>  -->
</body>
</html>
