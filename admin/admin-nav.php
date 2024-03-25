<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .navbar .right {
            float: right;
        }
    </style>
</head>
<body>

<div class="navbar">
  <a href="admin-dashboard.php">Home</a>
  <a href="admin-viewVehicles.php">Vehicles</a>
  <a href="admin-addVehicles.php">Add Vehicles</a>
  <a href="admin-rentRequests.php">Rent Requests</a>
  <div class="right">
    <a href="../functions/logout.php">Logout <?php echo $_SESSION["ad-username"];?></a>
  </div>
</div>

</body>
</html>
