<?php
session_start();

// Check if admin is not logged in,
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}
//include navbar
include '../connection.php';

//get vehicle id
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sql = "SELECT * FROM Vehicles WHERE vehicle_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind the vehicle ID
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = $_GET['id'];

        //execute
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);

            //check if vehicle exists
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result to variables
                mysqli_stmt_bind_result($stmt, $id, $name, $category, $mileage, $price, $availability, $image_filename);
                mysqli_stmt_fetch($stmt);
            } else {
                // Redirect to error page if the vehicle doesn't exist
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
    <!-- Add any additional styles or scripts here -->
</head>
<body>
    <h2><?php echo $name; ?></h2>
    <p>Category: <?php echo $category; ?></p>
    <p>Mileage: <?php echo $mileage; ?></p>
    <p>Price: <?php echo $price; ?></p>
    <p>Availability: <?php echo $availability ? 'Available' : 'Not Available'; ?></p>
    <img src="./vehicleImages/<?php echo $image_filename; ?>" alt="Vehicle Image" style="width: 600px;">
</body>
</html>
