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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lic_no = $_POST['lic_no'];
    $category = $_POST['category'];
    $model = $_POST['model'];
    $rent = $_POST['rent'];

    $insert_sql = "INSERT INTO vehicle (owner_id, lic_no, category, model, rent) 
                   VALUES ('$owner_id', '$lic_no', '$category', '$model', '$rent')";
    if (mysqli_query($conn, $insert_sql)) {
        echo '<script>
                 alert("Vehicle added successfully!");
                 window.location.href="owner_dashboard.php";
              </script>';
    } else {
        echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Vehicle</title>
  <style>
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 10px 10px 10px rgba(7, 85, 180, 0.4);
    }
    .container h1 {
      text-align: center;
    }
    .container form {
      display: flex;
      flex-direction: column;
    }
    .container input, .container select, .container button {
      margin-bottom: 10px;
      padding: 10px;
      font-size: 1rem;
    }
    .container button {
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
    }
    .container button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Add Vehicle</h1>
    <form method="POST" action="add_vehicle.php">
      <label for="lic_no">License Number:</label>
      <input type="text" id="lic_no" name="lic_no" required>
      <label for="category">Category:</label>
      <select id="category" name="category" required>
        <option value="car">Car</option>
        <option value="bike">Bike</option>
      </select>
      <label for="model">Model:</label>
      <input type="text" id="model" name="model" required>
      <label for="rent">Rent:</label>
      <input type="text" id="rent" name="rent" required>
      <button type="submit">Add Vehicle</button>
    </form>
  </div>
</body>
</html>