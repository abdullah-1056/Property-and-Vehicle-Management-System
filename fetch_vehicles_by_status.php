<?php
include("connection.php");

$sql = "SELECT * FROM vehicle WHERE status='available'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($vehicle = mysqli_fetch_assoc($result)) {
        echo '<div>';
        echo 'Vehicle ID: ' . $vehicle['vehicle_id'] . '<br>';
        echo 'Vehicle Type: ' . $vehicle['category'] . '<br>';
        echo 'Model: ' . $vehicle['model'] . '<br>';
        echo 'License No.: ' . $vehicle['lic_no'] . '<br>';
        echo 'Monthly Rent: ' . $vehicle['rent'] . '<br>';
        echo 'Status: ' . $vehicle['status'] . '<br>';
        echo '</div><br>';
    }
} else {
    echo 'No available vehicles found.';
}
?>