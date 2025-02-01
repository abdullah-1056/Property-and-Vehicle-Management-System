<?php
include("connection.php");

$type = $_GET['type'];
$sql = "SELECT * FROM property WHERE type='$type'";
$result = mysqli_query($conn, $sql);

while ($property = mysqli_fetch_assoc($result)) {
    echo '<div>';
    echo 'Property ID: ' . $property['property_id'] . '<br>';
    echo 'Property Type: ' . $property['type'] . '<br>';
    echo 'Location: ' . $property['location'] . '<br>';
    echo 'Monthly Rent: ' . $property['rent'] . '<br>';
    echo '<button onclick="window.location.href=\'reserve.php?property_id=' . $property['property_id'] . '\'">Rent Property</button>';
    echo '</div><br>';
}
?>