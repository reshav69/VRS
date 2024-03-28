<?php 
session_start();
//check session

if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
    header("location: user-login.php");
    exit();
}
include '../connection.php';

//variables
$uid=$vehicleId="";
$uid = $_SESSION['user_id'];

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
    $sql = "Delete FROM Rent where vehicle_id = '$vehicleId' AND user_id= '$uid'";
    $result = mysqli_query($conn,$sql);
    if (($result) ) {
        echo "the request was cancelled";
    }else{
        echo "The requested vehicle was not found";
        // header("location: error.php");
    }
}



