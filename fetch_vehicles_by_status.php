<?php
include("connection.php");

// Fetch vehicles that are not currently reserved
$sql = "SELECT * FROM vehicle 
        WHERE vehicle_id NOT IN (SELECT vehicle_id FROM reservation WHERE vehicle_id IS NOT NULL)";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($vehicle = mysqli_fetch_assoc($result)) {
        // Check if vehicle is reserved
        $check_sql = "SELECT COUNT(*) as count FROM reservation WHERE vehicle_id=" . $vehicle['vehicle_id'];
        $check_result = mysqli_query($conn, $check_sql);
        $check_row = mysqli_fetch_assoc($check_result);
        $status = ($check_row['count'] > 0) ? 'Reserved' : 'Available';
        
        echo '<div>';
        echo 'Vehicle ID: ' . $vehicle['vehicle_id'] . '<br>';
        echo 'Vehicle Type: ' . $vehicle['category'] . '<br>';
        echo 'Model: ' . $vehicle['model'] . '<br>';
        echo 'License No.: ' . $vehicle['lic_no'] . '<br>';
        echo 'Monthly Rent: ' . $vehicle['rent'] . '<br>';
        echo 'Status: ' . $status . '<br>';
        echo '</div><br>';
    }
} else {
    echo 'No available vehicles found.';
}
?>