<?php
session_start();

// Check if admin is not logged in, redirect to admin login page
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}

// Include database connection
include '../connection.php';

// Initialize variablesCar
$name = $model = $type = $mileage = $price = $availability =$description=$img= '';
$name_err =$model_err=$type_err = $mileage_err = $price_err = $availability_err =$vimage_err= '';
$errcnt = 0;

// Check if vehicle ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vehicleId = $_GET['id'];
}
if (empty($vehicleId)){
    header("location: error.php");
}

//check if vehicle exists
else{
    // Execute SQL query to retrieve vehicle details
    $sql = "SELECT * FROM Vehicles WHERE vehicle_id = '$vehicleId'";
    $result = mysqli_query($conn, $sql);

// Check if the query executed successfully
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

        // Retrieve vehicle details
            $name = $row['name'];
            $model=$row['model'];
            $type = $row['category'];
            $mileage = $row['mileage'];
            $price = $row['price'];
            $description = $row['description'];
            $availability = $row['availability'];
            $img = $row['image_filename'];

            // mysqli_free_result($result);
        } else {
        // Vehicle not found
            echo "Vehicle not found.";
            exit();
        }
    } else {
    // Error executing query
        echo "Oops! Something went wrong. Please try again later.";
        exit();
    }

}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle</title>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/details.css">
    <style>

    </style>
</head>
<body>
    <?php include 'admin-nav.php' ?>
    <h2>Edit Vehicle</h2>
    <div class="detail-container">
    <div class="form-container detail-left">
    <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $vehicleId ?>">
        <div class="inp-grp">
            <label for="name">Vehicle Name: </label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
            <span class="inp-err"><?php echo $name_err; ?></span>
        </div>

        <div class="inp-grp">
            <label for="type">Vehicle Type: </label>
            <select name="type">
                <option value="">--> Choose one <--</option>
                <option value="Bicycle"<?php echo isset($type) && $type == 'Bicycle' ? 'selected' : ''; ?>>Bicycle</option>
                <option value="Car" <?php echo isset($type) && $type == 'Car' ? 'selected' : ''; ?>>Car</option>
                <option value="Motorcycle" <?php echo isset($type) && $type == 'Motorcycle' ? 'selected' : ''; ?>>Motorcycle</option>
            </select>
            <span class="inp-err"><?php echo $type_err; ?></span>
        </div>

        <div class="inp-grp">
            <label for="price">Price per day: </label>
            <input type="number" name="price" value="<?php echo isset($price) ? $price : ''; ?>">
            <span class="inp-err"><?php echo $price_err; ?></span>
        </div>

        <div class="inp-grp">
            <label for="mileage">Mileage: </label>
            <input type="number" name="mileage" value="<?php echo isset($mileage) ? $mileage : ''; ?>">
            <span class="inp-err"><?php echo $mileage_err; ?></span>
        </div>
        <div class="inp-grp">
            <label for="model">model: </label>
            <input type="text" name="model" value="<?php echo isset($model) ? $model : ''; ?>">
            <span class="inp-err"><?php echo $model_err; ?></span>
        </div>

        <div class="inp-grp">
            <label for="description">Vehicle desc: </label>
            <textarea name="description" placeholder="Enter description" rows="5" cols="59" >
                <?php echo isset($description) ? $description : ''; ?>
            </textarea>
        </div>

<!--         <div class="inp-grp">
            <label for="vimage">Upload image</label>
            <input type="file" name="vimage" id="vimage" />
            <span class="inp-err"><?php echo $vimage_err; ?></span>
        </div> -->


        <div class="inp-grp">
            <label>Availability</label>
            <select name="availability">
                <option value="">Choose</option>
                <option value="1"<?php echo isset($availability) && $availability ? ' selected' : ''; ?>>Available</option>
                <option value="0"<?php echo isset($availability) && !$availability ? ' selected' : ''; ?>>Not Available</option>
            </select>
            <span><?php echo $availability_err; ?></span>
        </div>
        <div class="inp-grp">
            <button type="submit" class="loginbtn" name="update">Update</button>

            <!-- <a class="loginbtn" href="admin-deleteVehicle.php?id=<?php //echo $vehicleId; ?>" onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a> -->
        </div>
    </form>
    </div>
    <div class="detail-right">
        <img src="../vehicleImages/<?php echo $img ?>" alt="vehicle image">
    </div>
    </div>
</body>
</html>
