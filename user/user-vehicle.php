<?php 
session_start();
//check session

if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
    header("location: user-login.php");
    exit();
}
include '../connection.php';
//get url info

//check if vehicle exists

//rent

//if already rented dont


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
</head>
<body>
    <h2><?php echo $name; ?></h2>
    <p>Category: <?php echo $category; ?></p>
    <p>Mileage: <?php echo $mileage; ?></p>
    <p>Price: <?php echo $price; ?></p>
    <p>Availability: <?php echo $availability ? 'Available' : 'Not Available'; ?></p>
    <img src="../vehicleImages/<?php echo $image_filename; ?>" alt="Vehicle Image" style="width: 600px;">
    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
        <button name="btnRent" class="btn-rent">Rent</button>
    </form>
</body>
</html>
