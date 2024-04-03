<?php
	$id = trim($_POST["id"]);
    $name = trim($_POST["name"]);
    $model = trim($_POST["model"]);
    $type = trim($_POST["type"]);
    $mileage = trim($_POST["mileage"]);
    $price = trim($_POST["price"]);
    $description = trim($_POST["description"]);
    $availability = trim($_POST["availability"]);
    include '../connection.php';

    $sql = "UPDATE Vehicles SET name='$name', category='$type', mileage='$mileage', price='$price',description='$description', availability='$availability' WHERE vehicle_id=$id";

    if (mysqli_query($conn,$sql)) {
    	echo "the record was updated";
    }
    else{
    	echo "some error occured";
    }

echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
?>
