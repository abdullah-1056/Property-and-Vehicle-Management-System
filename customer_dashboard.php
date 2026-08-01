<?php
include("connection.php");
session_start();

if (!isset($_SESSION['phone_no'])) {
    echo '<script>
             alert("You are not logged in. Please log in first.");
             window.location.href="login.php";
          </script>';
    exit();
}

// Assume session is started and phone_no is stored in session
$phone_no = $_SESSION['phone_no'];

// Fetch customer details
$customer_sql = "SELECT * FROM customer WHERE phone_no='$phone_no'";
$customer_result = mysqli_query($conn, $customer_sql);
$customer = mysqli_fetch_assoc($customer_result);
$cust_id = $customer['cust_id'];

// Fetch reserved properties
$reserved_properties_sql = "SELECT property.* FROM property 
                            JOIN reservation ON property.property_id = reservation.property_id 
                            WHERE reservation.cust_id = $cust_id";
$reserved_properties_result = mysqli_query($conn, $reserved_properties_sql);

// Fetch reserved vehicles
$reserved_vehicles_sql = "SELECT vehicle.* FROM vehicle 
                          JOIN reservation ON vehicle.vehicle_id = reservation.vehicle_id 
                          WHERE reservation.cust_id = $cust_id";
$reserved_vehicles_result = mysqli_query($conn, $reserved_vehicles_sql);

// Fetch available properties based on type
$property_type = isset($_GET['property_type']) ? $_GET['property_type'] : 'house';
$available_properties_sql = "SELECT * FROM property WHERE status='available' AND type='$property_type'";
$available_properties_result = mysqli_query($conn, $available_properties_sql);

// Fetch available vehicles based on type
$vehicle_type = isset($_GET['vehicle_type']) ? $_GET['vehicle_type'] : 'car';
$available_vehicles_sql = "SELECT * FROM vehicle WHERE status='available' AND category='$vehicle_type'";
$available_vehicles_result = mysqli_query($conn, $available_vehicles_sql);

// Get query parameters for reservation form
$item_type = isset($_GET['item_type']) ? $_GET['item_type'] : '';
$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';
$rent = isset($_GET['rent']) ? $_GET['rent'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard</title>
  <style>
    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }
    .tabs {
      display: flex;
      cursor: pointer;
    }
    .tab {
      flex: 1;
      padding: 10px;
      text-align: center;
      background-color: #f1f1f1;
      border: 1px solid #ccc;
    }
    .tab-content {
      display: none;
      padding: 20px;
      border: 1px solid #ccc;
      border-top: none;
    }
    .tab-content.active {
      display: block;
    }
    .logout {
      position: fixed;
      bottom: 20px;
      left: 20px;
    }
  </style>
  <script>
    function showTab(tabIndex) {
      var tabs = document.querySelectorAll('.tab-content');
      tabs.forEach(function(tab, index) {
        tab.classList.remove('active');
        if (index === tabIndex) {
          tab.classList.add('active');
        }
      });
    }

    function showProperties(type) {
      window.location.href = 'customer_dashboard.php?property_type=' + type + '&tab=1';
    }

    function showVehicles(type) {
      window.location.href = 'customer_dashboard.php?vehicle_type=' + type + '&tab=2';
    }

    // Show the reservation form tab if redirected with query parameters
    window.onload = function() {
      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('tab')) {
        showTab(parseInt(urlParams.get('tab')));
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <h1>Customer Dashboard</h1>
    <div class="tabs">
      <div class="tab" onclick="showTab(0)">Customer Details</div>
      <div class="tab" onclick="showTab(1)">Rental Options for Property</div>
      <div class="tab" onclick="showTab(2)">Rental Options for Vehicle</div>
      <div class="tab" onclick="showTab(3)">Reservation Form</div>
    </div>
    <div class="tab-content active">
      <h2>Customer Details</h2>
      <p>Customer ID: <?php echo $customer['cust_id']; ?></p>
      <p>Name: <?php echo $customer['name']; ?></p>
      <p>Phone Number: <?php echo $customer['phone_no']; ?></p>
      <p>Address: <?php echo $customer['address']; ?></p>
      <h3>Reserved Properties</h3>
      <ul>
        <?php while ($property = mysqli_fetch_assoc($reserved_properties_result)) { ?>
          <li><?php echo $property['property_id'] . ' - ' . $property['type'] . ' - ' . $property['location']; ?></li>
        <?php } ?>
      </ul>
      <h3>Reserved Vehicles</h3>
      <ul>
        <?php while ($vehicle = mysqli_fetch_assoc($reserved_vehicles_result)) { ?>
          <li><?php echo $vehicle['vehicle_id'] . ' - ' . $vehicle['category'] . ' - ' . $vehicle['model']; ?></li>
        <?php } ?>
      </ul>
    </div>
    <div class="tab-content">
      <h2>Rental Options for Property</h2>
      <form>
        <input type="radio" name="property_type" value="house" onclick="showProperties('house')" <?php if ($property_type == 'house') echo 'checked'; ?>> House
        <input type="radio" name="property_type" value="office" onclick="showProperties('office')" <?php if ($property_type == 'office') echo 'checked'; ?>> Office
        <input type="radio" name="property_type" value="shop" onclick="showProperties('shop')" <?php if ($property_type == 'shop') echo 'checked'; ?>> Shop
      </form>
      <ul>
        <?php if (mysqli_num_rows($available_properties_result) > 0) { ?>
          <?php while ($property = mysqli_fetch_assoc($available_properties_result)) { ?>
            <li>
              <?php echo $property['property_id'] . ' - ' . $property['type'] . ' - ' . $property['location'] . ' - ' . $property['rent']; ?>
              <form method="GET" action="customer_dashboard.php" style="display:inline;">
                <input type="hidden" name="tab" value="3">
                <input type="hidden" name="item_type" value="property">
                <input type="hidden" name="item_id" value="<?php echo $property['property_id']; ?>">
                <input type="hidden" name="rent" value="<?php echo $property['rent']; ?>"><br>
                <button type="submit">Reserve</button><br><br>
              </form>
            </li>
          <?php } ?>
        <?php } else { ?>
          <li>No available properties found.</li>
        <?php } ?>
      </ul>
    </div>
    <div class="tab-content">
      <h2>Rental Options for Vehicle</h2>
      <form>
        <input type="radio" name="vehicle_type" value="car" onclick="showVehicles('car')" <?php if ($vehicle_type == 'car') echo 'checked'; ?>> Car
        <input type="radio" name="vehicle_type" value="bike" onclick="showVehicles('bike')" <?php if ($vehicle_type == 'bike') echo 'checked'; ?>> Bike
      </form>
      <ul>
        <?php if (mysqli_num_rows($available_vehicles_result) > 0) { ?>
          <?php while ($vehicle = mysqli_fetch_assoc($available_vehicles_result)) { ?>
            <li>
              <?php echo $vehicle['vehicle_id'] . ' - ' . $vehicle['category'] . ' - ' . $vehicle['model'] . ' - ' . $vehicle['rent']; ?>
              <form method="GET" action="customer_dashboard.php" style="display:inline;">
                <input type="hidden" name="tab" value="3">
                <input type="hidden" name="item_type" value="vehicle">
                <input type="hidden" name="item_id" value="<?php echo $vehicle['vehicle_id']; ?>">
                <input type="hidden" name="rent" value="<?php echo $vehicle['rent']; ?>"><br>
                <button type="submit">Reserve</button><br>
              </form>
            </li>
          <?php } ?>
        <?php } else { ?>
          <li>No available vehicles found.</li>
        <?php } ?>
      </ul>
    </div>
    <div class="tab-content">
      <h2>Reservation Form</h2>
      <form method="POST" action="reserve.php">
        <input type="hidden" name="customer_id" value="<?php echo $customer['cust_id']; ?>">
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
    </div>
    <div class="logout">
      <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
  </div>
</body>
</html>