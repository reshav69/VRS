<?php
session_start();

// Check if admin is not logged in,
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}
//include navbar

include '../connection.php';
//get url info
$vehicle_data=$name="";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vehicleId = $_GET['id'];
}
if (empty($vehicleId)){
    header("location: error.php");
}
//check if vehicle exists
else{
    $sql = "SELECT * FROM Vehicles where vehicle_id = '$vehicleId'";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) == 1) {
        $vehicle_data = mysqli_fetch_assoc($result);
    }else{
        echo "The requested vehicle was not found";
        // header("location: error.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vehicle_data['model']; ?></title>
</head>
<body>
    <h2><?php echo $vehicle_data['name']; ?></h2>
    <p>Id: <?php echo $vehicle_data['vehicle_id']; ?></p>
    <p>Model: <?php echo $vehicle_data['model']; ?></p>
    <p>Category: <?php echo $vehicle_data['category']; ?></p>
    <p>Mileage: <?php echo $vehicle_data['mileage']; ?>km per litre</p>
    <p>Price: <?php echo $vehicle_data['price'] ?></p>
    <p> <?php echo $vehicle_data['description']; ?></p>
    <p>Availability: <?php echo $vehicle_data['availability'] ? 'Available' : 'Not Available'; ?></p>
    <img src="../vehicleImages/<?php echo $vehicle_data['image_filename']; ?>" alt="Vehicle Image" style="width: 500px;">
</body>
</html>

