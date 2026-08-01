<?php
include("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user_type'];
    $phone_no = $_POST['phone_no'];
    $password = $_POST['pass']; // This will be ignored in the verification

    $phone_no = mysqli_real_escape_string($conn, $phone_no);

    if ($user_type == 'owner') {
        $sql = "SELECT owner_id FROM owner WHERE phone_no='$phone_no'";
    } else {
        $sql = "SELECT cust_id FROM customer WHERE phone_no='$phone_no'";
    }

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['phone_no'] = $phone_no; // Set the phone_no session variable
        if ($user_type == 'owner') {
            $_SESSION['owner_id'] = $row['owner_id'];
            header("Location: owner_dashboard.php");
        } else {
            $_SESSION['customer_id'] = $row['cust_id'];
            header("Location: customer_dashboard.php");
        }
        exit();
    } else {
        echo '<script>
                 alert("Login failed. Invalid phone number!");
                 window.location.href="login.php";
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
  <title>Login</title>
  <style>
    .login-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 10px 10px 10px rgba(7, 85, 180, 0.5);

    }
    .login-container h1 {
      text-align: center;
    }
    .login-container form {
      display: flex;
      flex-direction: column;
    }
    .login-container input, .login-container select, .login-container button {
      margin-bottom: 10px;
      padding: 10px;
      font-size: 1rem;
      border-radius: 6px;
      border: 1px solid black;
    }
    .login-container button {
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .login-container button:hover {
      background-color: #0056b3;
    }
    .signup-container {
      text-align: center;
      margin-top: 20px;
    }
    .signup-container button {
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      padding: 10px 20px;
      margin: 5px;
    }
    .signup-container button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Login</h1>
    <form method="POST" action="login.php">
      <select name="user_type" required>
        <option value="" disabled selected>Select User Type</option>
        <option value="owner">Owner</option>
        <option value="customer">Customer</option>
      </select>
      <input type="text" name="phone_no" placeholder="Phone Number" required>
      <input type="password" name="pass" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <div class="signup-container">
      <p>Don't have an account? Sign up as:</p>
      <button onclick="window.location.href='signup_ow.php'">Owner</button>
      <button onclick="window.location.href='signup_cu.php'">Customer</button>
    </div>
  </div>
</body>
</html>