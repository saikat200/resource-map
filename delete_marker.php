<?php
// Connect to database
require 'connection.inc.php';


// Check connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}


parse_str(file_get_contents("php://input"), $deleteVars);
$markerId = $deleteVars['marker_id'];

// Delete the marker from the database
$sql = "DELETE FROM markers WHERE id = '$markerId'";
if (mysqli_query($conn, $sql)) {
    echo "Marker deleted successfully";
} else {
    echo "Error deleting marker: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
