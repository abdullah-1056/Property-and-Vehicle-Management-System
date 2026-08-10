<?php
include("connection.php");

$status = isset($_GET['status']) ? $_GET['status'] : 'all';

if ($status == 'all') {
    $sql = "SELECT * FROM property";
} else if ($status == 'available') {
    // Properties not in reservation table
    $sql = "SELECT * FROM property 
            WHERE property_id NOT IN (SELECT property_id FROM reservation WHERE property_id IS NOT NULL)";
} else if ($status == 'reserved') {
    // Properties in reservation table
    $sql = "SELECT * FROM property 
            WHERE property_id IN (SELECT property_id FROM reservation WHERE property_id IS NOT NULL)";
} else {
    $sql = "SELECT * FROM property";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($property = mysqli_fetch_assoc($result)) {
        // Check if property is reserved
        $check_sql = "SELECT COUNT(*) as count FROM reservation WHERE property_id=" . $property['property_id'];
        $check_result = mysqli_query($conn, $check_sql);
        $check_row = mysqli_fetch_assoc($check_result);
        $prop_status = ($check_row['count'] > 0) ? 'Reserved' : 'Available';
        
        echo '<div>';
        echo 'Property ID: ' . $property['property_id'] . '<br>';
        echo 'Property Type: ' . $property['type'] . '<br>';
        echo 'Location: ' . $property['location'] . '<br>';
        echo 'Monthly Rent: ' . $property['rent'] . '<br>';
        echo 'Status: ' . $prop_status . '<br>';
        echo '</div><br>';
    }
} else {
    echo 'No properties found.';
}
?> 