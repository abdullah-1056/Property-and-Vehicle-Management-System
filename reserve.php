<?php
include("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $item_type = $_POST['item_type'];
    $item_id = $_POST['item_id'];
    $rent_date = $_POST['rent_date'];

    // Fetch owner_id based on item_type and item_id
    if ($item_type == 'property') {
        $owner_sql = "SELECT owner_id FROM property WHERE property_id='$item_id' AND status='available'";
    } else if ($item_type == 'vehicle') {
        $owner_sql = "SELECT owner_id FROM vehicle WHERE vehicle_id='$item_id' AND status='available'";
    }
    $owner_result = mysqli_query($conn, $owner_sql);
    if (mysqli_num_rows($owner_result) > 0) {
        $owner = mysqli_fetch_assoc($owner_result);
        $owner_id = $owner['owner_id'];

        if ($item_type == 'property') {
            $sql = "INSERT INTO reservation (cust_id, property_id, rent_date, owner_id, transaction_id) VALUES ('$customer_id', '$item_id', '$rent_date', '$owner_id', 1)";
            $update_sql = "UPDATE property SET status='reserved' WHERE property_id='$item_id'";
        } else if ($item_type == 'vehicle') {
            $sql = "INSERT INTO reservation (cust_id, vehicle_id, rent_date, owner_id, transaction_id) VALUES ('$customer_id', '$item_id', '$rent_date', '$owner_id', 1)";
            $update_sql = "UPDATE vehicle SET status='reserved' WHERE vehicle_id='$item_id'";
        }

        if (mysqli_query($conn, $sql) && mysqli_query($conn, $update_sql)) {
            echo '<script>
                     alert("Reservation successful!");
                     window.location.href="customer_dashboard.php";
                  </script>';
        } else {
            echo '<script>
                     alert("Reservation failed. Please try again.");
                     window.location.href="customer_dashboard.php";
                  </script>';
        }
    } else {
        echo '<script>
                 alert("Item is already reserved.");
                 window.location.href="customer_dashboard.php";
              </script>';
    }

    mysqli_close($conn);
} else {
    // Handle GET request to display the reservation form
    $item_type = isset($_GET['item_type']) ? $_GET['item_type'] : '';
    $item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';
    $rent = isset($_GET['rent']) ? $_GET['rent'] : '';
    $customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '';

    // Determine if the request is for a vehicle or property
    if (isset($_GET['vehicle_id'])) {
        $item_type = 'vehicle';
        $item_id = $_GET['vehicle_id'];
        // Fetch rent for the vehicle
        $sql = "SELECT rent FROM vehicle WHERE vehicle_id='$item_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $vehicle = mysqli_fetch_assoc($result);
            $rent = $vehicle['rent'];
        }
    } elseif (isset($_GET['property_id'])) {
        $item_type = 'property';
        $item_id = $_GET['property_id'];
        // Fetch rent for the property
        $sql = "SELECT rent FROM property WHERE property_id='$item_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $property = mysqli_fetch_assoc($result);
            $rent = $property['rent'];
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reservation Form</title>
    </head>
    <body>
        <h2>Reservation Form</h2>
        <form method="POST" action="reserve.php">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <label for="item_type">Select Type:</label><br>
            <input type="radio" name="item_type" value="property" <?php if ($item_type == 'property') echo 'checked'; ?> required> Property
            <input type="radio" name="item_type" value="vehicle" <?php if ($item_type == 'vehicle') echo 'checked'; ?> required> Vehicle<br>
            <label for="item_id">Property/Vehicle ID:</label><br>
            <input type="text" name="item_id" value="<?php echo $item_id; ?>" required readonly><br>
            <label for="rent_date">Rent Date:</label><br>
            <input type="date" name="rent_date" required><br>
            <label for="rent">Rent:</label><br>
            <input type="text" name="rent" value="<?php echo $rent; ?>" readonly><br><br>
            <button type="submit">Reserve</button>
        </form>
    </body>
    </html>
    <?php
}
?>