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

    $sql = "INSERT INTO owner (nid, name, phone_no, address) VALUES ('$nid', '$name', '$phone_no', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>
                 alert("Sign up successful! Please log in.");
                 window.location.href="login.php";
              </script>';
    } else {
        echo '<script>
                 alert("Sign up failed. Please try again.");
                 window.location.href="signup_ow.php";
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
  <title>Owner Sign Up</title>
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
      margin-bottom: 20px;
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
    button[type="submit"] {
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
    button[type="submit"]:hover {
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
    <h1>Owner Sign Up</h1>
    <form method="POST" action="signup_ow.php">
    <input type="text" name="name" placeholder="Name" required>
      <input type="text" name="nid" placeholder="NID" required>
      <input type="text" name="phone_no" placeholder="Phone Number" required>
      <input type="text" name="address" placeholder="Address" required>
      <input type="password" name="pass" placeholder="Password" required>
      <button type="submit">Sign Up</button>
    </form>
  </div>
</body>
</html>