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

// Fetch owner details
$owner_sql = "SELECT * FROM owner WHERE phone_no='$phone_no'";
$owner_result = mysqli_query($conn, $owner_sql);
$owner = mysqli_fetch_assoc($owner_result);
$owner_id = $owner['owner_id'];

// Fetch owner's properties
$owner_properties_sql = "SELECT property.*, reservation.cust_id, reservation.rent_date 
                         FROM property 
                         LEFT JOIN reservation ON property.property_id = reservation.property_id 
                         WHERE property.owner_id = $owner_id";
$owner_properties_result = mysqli_query($conn, $owner_properties_sql);

// Fetch owner's vehicles
$owner_vehicles_sql = "SELECT vehicle.*, reservation.cust_id, reservation.rent_date 
                       FROM vehicle 
                       LEFT JOIN reservation ON vehicle.vehicle_id = reservation.vehicle_id 
                       WHERE vehicle.owner_id = $owner_id";
$owner_vehicles_result = mysqli_query($conn, $owner_vehicles_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f5f6fa;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 240px;
      background-color: #1a1d2e;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 0;
    }

    .sidebar h1 {
      font-size: 1.8rem;
      margin-bottom: 30px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      width: 83%;
      padding: 15px 20px;
      text-align: left;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: background 0.3s ease;
    }

    .sidebar a:hover {
      background-color: #2e3852;
    }

    .logout {
      margin-top: auto;
      margin-bottom: 20px;
      font-size: 1.2rem;
      align-items: left;
      
    }

    .sidebar .logout a:hover{
      background-color:rgb(164, 23, 37); 
      border-radius: 6px;
    }

    /* Main content */
    .main-content {
      margin-left: 260px;
      padding: 20px;
    }

    .card {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
      margin-bottom: 20px;
      font-size: 1.5rem;
    }

    .card ul {
      list-style-type: none;
      padding: 0;
    }

    .card ul li {
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .card ul li span.status {
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: bold;
    }

    .status.available {
      background-color: #e7f9ee;
      color: #28a745;
    }

    .status.booked {
      background-color: #fbeaea;
      color: #dc3545;
    }

    .add-button {
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 1rem;
      cursor: pointer;
      margin-top: 10px;
      display: block;
    }

    .add-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h1>RentEase</h1>
    <a href="#"><i class="fas fa-th-large"></i> Dashboard</a>
    <div class="logout">
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Owner Details -->
    <div class="card">
      <h2>Owner Details</h2>
      <p><strong>Owner ID:</strong> <?php echo $owner['owner_id']; ?></p>
      <p><strong>Name:</strong> <?php echo $owner['name']; ?></p>
      <p><strong>Phone Number:</strong> <?php echo $owner['phone_no']; ?></p>
      <p><strong>Address:</strong> <?php echo $owner['address']; ?></p>
    </div>

    <!-- Properties -->
    <div class="card">
      <h2>Properties</h2>
      <button class="add-button" onclick="window.location.href='add_property.php'">+ Add Property</button>
      <ul>
        <?php while ($property = mysqli_fetch_assoc($owner_properties_result)) { ?>
          <li>
            <?php echo $property['property_id'] . ' - ' . $property['type'] . ' - ' . $property['location'] . ' - ' . $property['rent']; ?>
            <?php if ($property['cust_id']) { ?>
              <span class="status booked">Booked</span>
            <?php } else { ?>
              <span class="status available">Available</span>
            <?php } ?>
          </li>
        <?php } ?>
      </ul>
    </div>

    <!-- Vehicles -->
    <div class="card">
      <h2>Vehicles</h2>
      <button class="add-button" onclick="window.location.href='add_vehicle.php'">+ Add Vehicle</button>
      <ul>
        <?php while ($vehicle = mysqli_fetch_assoc($owner_vehicles_result)) { ?>
          <li>
            <?php echo $vehicle['vehicle_id'] . ' - ' . $vehicle['category'] . ' - ' . $vehicle['model'] . ' - ' . $vehicle['rent']; ?>
            <?php if ($vehicle['cust_id']) { ?>
              <span class="status booked">Booked</span>
            <?php } else { ?>
              <span class="status available">Available</span>
            <?php } ?>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</body>
</html>