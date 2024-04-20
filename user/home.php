<?php
session_start();
include '../connection.php';

$vehicles = [];

$sql = "SELECT * FROM Vehicles ORDER BY RAND() LIMIT 4";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vehicles[] = $row;
    }
}

mysqli_free_result($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/view.css">
    <title>VRS</title>
</head>

<body>
    <?php include 'user-nav.php'?>
    <div class="container">
        <div class="welcome-txt">
            <h2>rent your desired vehicle in resonable price</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                etdolore magna aliqua.
            </p>
            <?php if (isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] === true) : ?>
            <button class="buttons">View Vehicles</button>
            <?php else : ?>
                <button class="buttons">Register Now</button>
            <?php endif; ?>
        </div>
    </div>

    <!--Showing vehicles-->
    <section>
        <div class="headings">View Vehicles</div>
        <div class="vehicles">
            <?php foreach ($vehicles as $vehicle): ?>
            <div class="vehicle-container">
                <div class="box">
                    <div class="img-container">
                        <img src="../vehicleImages/<?php echo $vehicle['image_filename']?>" alt="vehicleimage">
                    </div>
                    <div class="model-info">
                        <li>model:<?php echo $vehicle['model']; ?> </li>
                        <li>mileage: <?php echo $vehicle["mileage"]; ?></li>
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
            <?php endforeach; ?>
        </div>
    </section>

    <!--footer-->
    <?php include 'footer.php' ?>
    
</body>

</html>