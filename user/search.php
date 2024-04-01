<?php
session_start();

//check login status
if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
	header("location: user-login.php");
	exit();
}

$searchV =$vType= '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve search parameters from the form
	$searchV = $_POST["searchV"];
	$vType = $_POST["vType"];

	$sql = "SELECT * FROM your_table_name WHERE 
	name like '%$searchV%' or type like '%$vType%'  ";

    // Execute the SQL query
	$result = mysqli_query($conn, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Search</title>
</head>
<body>
	<h1>Search vehicle</h1>
	<form action="search.php" method="post">

		<input type="text" name="searchInp" id="sinp">
		Choose the type of the Vehicle:
		<select name="type">
			<option value="">--Choose One--</option>
			<option value="bicycle"></option>
		</select>
		<input type="submit" name="searchbtn" id="sbtn" class="searchBtn" value="Search">	
	</form>

</body>
</html>