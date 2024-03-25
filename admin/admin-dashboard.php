<?php 
session_start();

//check login status
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
	header("location: admin-login.php");
	exit();
}
include 'admin-nav.php';
$username = $_SESSION["ad-username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard</title>
</head>
<body>

	<div class="dateTime">
		<p id="clock" onload="currentTime()"></p>
	</div>

	<div class="adminInfo">
		<p>Welcome <?php echo "$username"?></p>
	</div>
	<br>
	<a href="../functions/logout.php">logout</a>
	<script type="text/javascript" src="../js/clock.js"></script>
</body>
</html>