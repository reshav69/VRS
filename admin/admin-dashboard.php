<?php 
session_start();

//check login status
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
	header("location: admin-login.php");
	exit();
}
include 'admin-nav.php';
$username = $_SESSION["ad-username"];
// Initialize variables
$unum = $vnum = $pnum = $anum = '';

// Include your database connection
include '../connection.php';

// Count the number of users
$usql = 'SELECT COUNT(*) FROM Users';
if ($uresult = mysqli_query($conn, $usql)) {
    $urow = mysqli_fetch_row($uresult);
    $unum = $urow[0]; // Number of users
    mysqli_free_result($uresult);
}

// Count the number of vehicles
$vsql = 'SELECT COUNT(*) FROM Vehicles';
if ($vresult = mysqli_query($conn, $vsql)) {
    $vrow = mysqli_fetch_row($vresult);
    $vnum = $vrow[0]; // Number of vehicles
    mysqli_free_result($vresult);
}

// Count the number of pending vehicles
$psql = "SELECT COUNT(*) FROM Rent WHERE status = 'pending'";
if ($presult = mysqli_query($conn, $psql)) {
    $prow = mysqli_fetch_row($presult);
    $pnum = $prow[0]; // Number of pending vehicles
    mysqli_free_result($presult);
}

// Count the number of approved vehicles
$asql = "SELECT COUNT(*) FROM Rent WHERE status = 'approved'";
if ($aresult = mysqli_query($conn, $asql)) {
    $arow = mysqli_fetch_row($aresult);
    $anum = $arow[0]; // Number of approved vehicles
    mysqli_free_result($aresult);
}

// Close database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../css/user-dash.css">
</head>
<body>
	<div class="dash-container">
	<div class="dateTime">
		<p id="clock" onload="currentTime()"></p>
	</div>

	<div class="info">
		<p>Welcome <?php echo "$username"?></p>
	</div>
	<br>

	<a href="../functions/logout.php">logout</a>
	</div>

	<div class="dash-container">
		<p class="dp">Number of users registered: <?php echo "$unum"; ?></p>
		<br>
		<p class="dp">Number of Vehicles: <?php echo "$vnum"; ?></p>
		<p class="dp">Pending Requests: <?php echo "$pnum"; ?></p>
		<p class="dp">Approved Requests: <?php echo $vnum ?></p>
	</div>
	<script type="text/javascript" src="../js/clock.js"></script>
</body>
</html>