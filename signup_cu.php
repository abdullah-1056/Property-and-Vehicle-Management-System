<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nid = $_POST['nid'];
    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    

    $nid = mysqli_real_escape_string($conn, $nid);
    $name = mysqli_real_escape_string($conn, $name);
    $phone_no = mysqli_real_escape_string($conn, $phone_no);
    $address = mysqli_real_escape_string($conn, $address);

    $sql = "INSERT INTO customer (nid, name, phone_no, address) VALUES ('$nid', '$name', '$phone_no', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>
                 alert("Sign up successful! Please log in.");
                 window.location.href="login.php";
              </script>';
    } else {
        echo '<script>
                 alert("Sign up failed. Please try again.");
                 window.location.href="signup_customer.php";
              </script>';
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Sign Up</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .signup-container {
      width: 400px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 10px 10px 10px rgba(17, 151, 7, 0.3);
      border-radius: 10px;
    }
    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 15px;
      margin-bottom: 5px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    input[type="text"], input[type="password"], input[type="email"], input[type="tel"], textarea {
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    input[type="submit"] {
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      background-color: #5cb85c;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #4cae4c;
    }
    .form-group {
      display: flex;
      flex-direction: column;
    }
    .form-group label {
      margin-bottom: 5px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h1>Customer Sign Up</h1>
    <form method="POST" action="signup_cu.php">
    <div class="form-group">
        <input type="text" id="name" name="name" placeholder="Name" required>
      </div>

      <div class="form-group">
        <input type="text" id="nid" name="nid" placeholder="NID" required>
      </div>

      <div class="form-group">
        <input type="tel" id="phone_no" name="phone_no" placeholder="Phone Number" required>
      </div>

      <div class="form-group">
        <textarea id="address" name="address" placeholder="Address" required></textarea>
      </div>

      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="password" required>
      </div>

      <input type="submit" value="Sign Up">
    </form>
  </div>
</body>
</html>