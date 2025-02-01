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
    $rent = $_POST['rent'];
    $leasing_date = $_POST['leasing_date'];
    $type = $_POST['type'];
    $location = $_POST['location'];

    $insert_sql = "INSERT INTO property (owner_id, rent, leasing_date, type, location) 
                   VALUES ('$owner_id', '$rent', '$leasing_date', '$type', '$location')";
    if (mysqli_query($conn, $insert_sql)) {
        echo '<script>
                 alert("Property added successfully!");
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
  <title>Add Property</title>
  <style>
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 10px 10px 10px rgba(44, 111, 211, 0.4);
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
    <h1>Add Property</h1>
    <form method="POST" action="add_property.php">
      <label for="rent">Rent:</label>
      <input type="text" id="rent" name="rent" required>
      <label for="leasing_date">Leasing Date:</label>
      <input type="date" id="leasing_date" name="leasing_date" required>
      <label for="type">Type:</label>
      <select id="type" name="type" required>
        <option value="house">House</option>
        <option value="office">Office</option>
        <option value="shop">Shop</option>
      </select>
      <label for="location">Location:</label>
      <textarea id="location" name="location" required></textarea><br>
      <button type="submit">Add Property</button>
    </form>
  </div>
</body>
</html>