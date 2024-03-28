<?php 
session_start();

//check login status
if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
	header("location: user-login.php");
	exit();
}
$name=$id=$vehicle_id='';
$name = $_SESSION['user-username'];
$id=$_SESSION['user_id'];

include "../connection.php";

$sql = "SELECT Vehicles.vehicle_id, Vehicles.name, Rent.request_date, Rent.status
FROM Rent
INNER JOIN Vehicles ON Rent.vehicle_id = Vehicles.vehicle_id
WHERE Rent.user_id='$id'";
$result = mysqli_query($conn, $sql);


// Close connection
mysqli_close($conn);



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Vehicles</title>
</head>
<body>
	<?php include "user-nav.php"; ?>
	<h2>Here are the vehicles you have rented</h2>

	<table border='1'>
		<tr>
			<th>Vehicle</th>
			<th>Request Date</th>
			<th>Status</th><th>Action</th>
		</tr>
		<?php while ($row = mysqli_fetch_assoc($result)) : ?>
			<tr>
				<td><a href="user-vehicle.php?id=<?php echo $row['vehicle_id']; ?>"><?php echo $row['name']; ?></a></td>
				<td><?php echo $row['request_date']; ?></td>
				<td><?php echo $row['status']; ?></td>
				<td>
                    <a href="user-cancel.php?id=<?php echo $row['vehicle_id']; ?>" onclick="return confirm('Are you sure you want to cancel this request?');">Cancel</a>
                </td>
			</tr>
		<?php endwhile; ?>
	</table>
</body>
</html>