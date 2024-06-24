<?php
session_start();

// Check if admin is not logged in,
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}
//include navbar

include '../connection.php';
//get url info
$vehicle_data=$name="";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vehicleId = $_GET['id'];
}
if (empty($vehicleId)){
    header("location: error.php");
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vehicle_data['name']; ?></title>
    <link rel="stylesheet" href="../css/details.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/general.css">
</head>
<body>
    <?php include 'admin-nav.php'; ?>
    <div class="detail-container">
        <div class="detail-left">
            <h2><?php echo $vehicle_data['name']; ?></h2>
            <p><b>Id: </b><?php echo $vehicle_data['vehicle_id']; ?></p>
            <p><b>Model: </b><?php echo $vehicle_data['model']; ?></p>
            <p><b>Category: </b><?php echo $vehicle_data['category']; ?></p>
            <p><b>Mileage: </b><?php echo $vehicle_data['mileage']; ?>km per litre</p>
            <p><b>Price: </b><?php echo $vehicle_data['price'] ?></p>
            <p <?php echo $vehicle_data['availability'] ? 'class=av' : 'class=notav'; ?>><b><?php echo $vehicle_data['availability'] ? 'Available' : 'Not Available'; ?></b></p><br>
            <p id="desc"> <?php echo $vehicle_data['description']; ?></p>
        </div>
        <div class="detail-right">
            <img src="../vehicleImages/<?php echo $vehicle_data['image_filename']; ?>" alt="Vehicle Image" style="width: 500px;">
            
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var descElement = document.getElementById('desc');
            var description = descElement.textContent; 
            
            var sentences = description.split('.');

            var ul = document.createElement('ul');

            sentences.forEach(function(sentence) {
                var trimmedSentence = sentence.trim();
                if (trimmedSentence) { 
                    var li = document.createElement('li');
                    li.textContent = trimmedSentence + '.'; 
                    ul.appendChild(li);
                }
            });
            descElement.innerHTML = '';
            descElement.appendChild(ul);
        });
    </script>
</body>
</html>

