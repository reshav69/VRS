<?php
session_start();

//check login status
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
	header("location: admin-login.php");
	exit();
}

$vehicle_data=$name="";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vehicleId = $_GET['id'];
}
if (empty($vehicleId)){
    header("location: error.php");
}
//check if vehicle exists
else{
    try {
            
    	include "../connection.php";
        $sql = "DELETE FROM Vehicles where vehicle_id = '$vehicleId'";
        $result = mysqli_query($conn,$sql);
        if ($result) {
            echo "The vehicle was DELETED!!!!";
        }else{
            echo "The requested vehicle was not deleted";
            // header("location: error.php");
        }
    } catch (Exception $e) {
        echo "<script>alert('The vehicle cannot be deleted');document.location='admin-viewVehicles.php'</script>";

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Delete Vehicle</title>
</head>
<body>
	
</body>
</html>