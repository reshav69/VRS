<?php 
session_start();
//check session

if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
    header("location: user-login.php");
    exit();
}
include '../connection.php';
include '../functions/validate.php';

//variables
$vehicle_data=$name=$user_id=$requestDate=$status=$availability=$rentDate=$rentDays=$rentmsg=$rentloc=$errDate = $errDay = $errLoc=$total=$msg="";
$errcnt=0;

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
    // $availability = $result['availability'];
}

//rent
//if already rented dont
if (isset($_POST['btnRent'])) {
    $user_id = $_SESSION['user_id'];
    $rentDate=$_POST['rentDate'];
    if (empty($rentDate)) {
        $errDate = "Enter the rent date";
        $errcnt++;
    }
    else{
        $rentDate=trim($_POST['rentDate']);
    }

    $rentDays=trim($_POST['rentDays']);
    if (empty($rentDays)) {
        $errDay = "Enter the number of days to rent for";
        $errcnt++;
    } else {
        if (validate_data($rentDays, '/^(?:[1-9]|[12]\d|30)$/' ) == false) {
          $errDay="Rent days must be from 1-30";
          $errcnt++;
      }
    }

    $rentloc=trim($_POST['rentloc']);
    if (empty($rentloc)) {
        $errLoc = "Enter the pickup location";
        $errcnt++;
    } else {
        if (validate_data($rentloc, '/^[a-zA-Z0-9]+$/' ) == false) {
          $errLoc="Location should not contain special characters";
          $errcnt++;
      }
    }

    if ($errcnt == 0) {
        $total = $vehicle_data['price'] * $rentDays;
        $rsql = "SELECT * FROM Rent WHERE user_id=$user_id AND vehicle_id=$vehicleId";
        $result = mysqli_query($conn,$rsql);

    //check if rented
        if (mysqli_num_rows($result) > 0) {
            $rentmsg =  "You have already sent rent request for this vehicle, if you want to re-rent, you can delete the previous request and try again";

        }else{//insert the request
        $requestDate=date("Y-m-d"); // Get current date
        $status='pending';
        $rentSql = "INSERT INTO Rent (user_id,vehicle_id,request_date,status,rent_date,rent_days,location) VALUES(?,?,?,?,?,?,?)";
        //prepare statement
        if ($stmt = mysqli_prepare($conn, $rentSql)) {
            //bind variables
            mysqli_stmt_bind_param($stmt, "iisssss", $user_id, $vehicleId, $requestDate, $status,$rentDate,$rentDays,$rentloc);
            if (mysqli_stmt_execute($stmt)) {
                $msg= "Rent request submitted successfully. your total is: $total";
            } else {
                $rentmsg= "Error submitting rent request.";
            }
        }else{
            $rentmsg ="Oops!!! something went wrong";
        }
        mysqli_stmt_close($stmt);
    }
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
    <?php include 'user-nav.php'; ?>
    <div class="detail-container">
        <div class="detail-left">
            <h2><?php echo $vehicle_data['name']; ?></h2>
            <p><b>Model:</b> <?php echo $vehicle_data['model']; ?></p>
            <p><b>Category:</b> <?php echo $vehicle_data['category']; ?></p>
            <p><b>Mileage:</b> <?php echo $vehicle_data['mileage']; ?> km per litre</p>
            <p><b>Price:</b> <?php echo $vehicle_data['price'] ?> per day</p>
            <p <?php echo $vehicle_data['availability'] ? 'class=av' : 'class=notav'; ?>><b><?php echo $vehicle_data['availability'] ? 'Available' : 'Not Available'; ?></b></p><br>
            <p> <?php echo $vehicle_data['description']; ?></p>
        </div>
        <div class="detail-right">
            <span class="error"><?php echo $rentmsg; ?></span>
            <span class="msg"><?php echo $msg; ?></span>

            <img src="../vehicleImages/<?php echo $vehicle_data['image_filename']; ?>" alt="Vehicle Image" style="width: 500px;">
            
            <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
                <div class="inp-grp">
                    <label for="rentDate">Enter the date to rent for</label>
                    <span class="error"><?php echo $errDate; ?></span>
                    <input type="date" name="rentDate" id="rentDate"><br>
                </div>
                <div class="inp-grp">
                    <label for="rentDays">How many days to rent for?</label>
                    <span class="error"><?php echo $errDay; ?></span>
                    <input type="text" name="rentDays" id="rentDays"><br>
                </div>
                <div class="inp-grp">
                    <label for="rentloc">Pickup location</label>
                    <span class="error"><?php echo $errLoc; ?></span>
                    <input type="text" name="rentloc" id="rentloc"><br>
                </div>
                <button name="btnRent" class="rentbtn" <?php if(!$vehicle_data['availability']) echo 'disabled'; ?>>Rent</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php' ?>

    <script>
        // Get today's date
var today = new Date().toISOString().split('T')[0];

// Set the minimum date for date input fields
document.getElementById("rentDate").min = today;
    </script>
</body>
</html>
