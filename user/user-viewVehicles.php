<?php
session_start();

if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
    header("location: user-login.php");
    exit();
}
include '../connection.php';

// Retrieve all vehicles from the database
$sql = "SELECT * FROM Vehicles";
$result = mysqli_query($conn, $sql);

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicles</title>
    <link rel="stylesheet" href="../css/tables.css">
    <link rel="stylesheet" href="../css/view.css">
</head>
<body>
    <?php include 'user-nav.php';?>
    <h2>Find Vehicles</h2>
    <p>You can search for vehicles <a href="search.php">here</a></p>
    <div class="vehicles">
        <?php while ($vehicle = mysqli_fetch_assoc($result)) : ?>
            <div class="vehicle-container">
                <div class="box">
                    <div class="img-container">
                        <img src="../vehicleImages/<?php echo $vehicle['image_filename']?>" alt="vehicleimage">
                    </div>
                    <div class="model-info">
                        <li>model:<?php echo $vehicle['model']; ?> </li>
                        <li>mileage: <?php echo $vehicle["mileage"]; ?></li>
                        <li><?php echo $vehicle["category"]; ?></li>
                        <li><?php echo $vehicle['availability'] ? 'Available' : 'Not Available'; ?></li>
                    </div>
                </div>

                <div class="vehicle-description">
                    <h2><a href="user-vehicle.php?id=<?php echo $vehicle['vehicle_id']; ?>"><?php echo $vehicle['name']; ?></a></h2>
                    <h3>Rs. <?php echo $vehicle['price']; ?> per day</h3>
                    <p>
                        <?php echo $vehicle['description']; ?>
                    </p>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>
