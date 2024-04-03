<?php
session_start();

// Check login status
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("location: user-login.php");
    exit();
}

include '../connection.php'; 

$searchV = $vType = '';
$result = null; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchV = $_POST["searchInp"];
    $vType = $_POST["type"];

    $sql = "SELECT * FROM Vehicles WHERE 
            name LIKE '%$searchV%' AND category LIKE '%$vType%'";

    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../css/view.css">
</head>
<body>
	<?php include 'user-nav.php'; ?>
    <h1>Search Vehicle</h1>
    <form action="search.php" method="post">
        <label for="searchInp">Enter the name of the vehicle: </label>
        <input type="text" name="searchInp" id="sinp" value="<?php echo htmlspecialchars($searchV); ?>">
        <label for="type">Choose the type of the vehicle: </label>
        <select name="type">
            <option value="">--Choose One--</option>
            <option value="bicycle" <?php echo ($vType == 'bicycle') ? 'selected' : ''; ?>>Bicycle</option>
            <option value="car" <?php echo ($vType == 'car') ? 'selected' : ''; ?>>Car</option>
			<option value="bike" <?php echo ($vType == 'bike') ? 'selected' : ''; ?>>Bike</option>            
        </select>
        <input type="submit" name="searchbtn" id="sbtn" class="searchBtn" value="Search">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $result) : ?>
        <h2>Search Results</h2>
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
    <?php endif; ?>
</body>
</html>
