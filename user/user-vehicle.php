<?php 
session_start();
//check session

if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
    header("location: user-login.php");
    exit();
}
include '../connection.php';

//variables
$vehicle_data=$name=$user_id=$requestDate=$status="";

//get url info
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vehicleId = $_GET['id'];
}

if (empty($vehicleId)){
    header("location: error.php");
    exit();
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

//rent
//if already rented dont
if (isset($_POST['btnRent'])) {
    $user_id = $_SESSION['user_id'];

    $rsql = "SELECT * FROM Rent WHERE user_id=$user_id AND vehicle_id=$vehicleId";
    $result = mysqli_query($conn,$rsql);

    //check if rented
    if (mysqli_num_rows($result) > 0) {
        echo "You have already sent rent request for this vehicle";//put in $rentmessage

    }else{//insert the request
        $requestDate=date("Y-m-d"); // Get current date
        $status='pending';
        $rentSql = "INSERT INTO Rent (user_id,vehicle_id,request_date,status) VALUES(?,?,?,?)";
        //prepare statement
        if ($stmt = mysqli_prepare($conn, $rentSql)) {
            //bind variables
            mysqli_stmt_bind_param($stmt, "iiss", $user_id, $vehicleId, $requestDate, $status);
            if (mysqli_stmt_execute($stmt)) {
                echo "Rent request submitted successfully.";//put in $rentmessage
            } else {
                echo "Error submitting rent request.";//put in $rentmessage
            }
        }else{
            echo "Oops!!! something went wrong";//put in $rentmessage
        }
    mysqli_stmt_close($stmt);
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

    <p>Model: <?php echo $vehicle_data['model']; ?></p>
    <p>Category: <?php echo $vehicle_data['category']; ?></p>
    <p>Mileage: <?php echo $vehicle_data['mileage']; ?>km per litre</p>
    <p>Price: <?php echo $vehicle_data['price'] ?></p>
    <p> <?php echo $vehicle_data['description']; ?></p>
    <p>Availability: <?php echo $vehicle_data['availability'] ? 'Available' : 'Not Available'; ?></p>
    <img src="../vehicleImages/<?php echo $vehicle_data['image_filename']; ?>" alt="Vehicle Image" style="width: 500px;">
    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
        <button name="btnRent" class="btn-rent">Rent</button>
    </form>
</body>
</html>
