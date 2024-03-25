<?php 
session_start();

//check login status
if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
	header("location: user-login.php");
	exit();
}

	//include navbar
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>user Dashboard</title>
</head>
<body>

	<div class="dateTime">
		<p id="clock" onload="currentTime()"></p>
		<?php echo $_SESSION['user-username']; ?>
		<?php echo $_SESSION['user_id']; ?>

	</div>

	<div class="userInfo">
		
	</div>
	<br>
	<a href="../functions/logout.php">logout</a>
	<script type="text/javascript" src="../js/clock.js"></script>
</body>
</html>