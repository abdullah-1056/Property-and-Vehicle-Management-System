<?php
include("connection.php");

$type = $_GET['type'];
$sql = "SELECT * FROM vehicle WHERE category='$type'";
$result = mysqli_query($conn, $sql);

while ($vehicle = mysqli_fetch_assoc($result)) {
    echo '<div>';
    echo 'Vehicle ID: ' . $vehicle['vehicle_id'] . '<br>';
    echo 'Vehicle Type: ' . $vehicle['category'] . '<br>';
    echo 'Model: ' . $vehicle['model'] . '<br>';
    echo 'License No.: ' . $vehicle['lic_no'] . '<br>';
    echo 'Monthly Rent: ' . $vehicle['rent'] . '<br>';
    echo '<button onclick="window.location.href=\'reserve.php?vehicle_id=' . $vehicle['vehicle_id'] . '\'">Rent Vehicle</button>';
    echo '</div><br>';
}
?>