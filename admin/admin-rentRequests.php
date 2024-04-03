<?php
session_start();


if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}

include '../connection.php';
$fin=false;

//get all data from database
$sql = "SELECT *
FROM Rent
INNER JOIN Users ON Rent.user_id = Users.user_id
INNER JOIN Vehicles ON Rent.vehicle_id = Vehicles.vehicle_id";
$result = mysqli_query($conn, $sql);


// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Requests</title>
    <link rel="stylesheet" href="../css/tables.css">
</head>
<body>
    <?php include 'admin-nav.php';?>
    <h2>Rent Requests</h2>
    <table border="1">
        <tr>
            <th>Request ID</th>
            <th>User</th>
            <th>Vehicle</th>
            <th>Request Date</th>
            <th>Status</th>
            <th>Contact</th>
            <th>Rent Date</th>
            <th>Renting for</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <?php if ($row['status'] == "finished") {
                $fin=true;
            } ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><a href="admin-vehicle.php?id=<?php echo $row['vehicle_id']; ?>"><?php echo $row['name']; ?></a></td>

                <td><?php echo $row['request_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['rent_date']; ?></td>
                <td><?php echo $row['rent_days']; ?> Days</td>
                <td>
                <form action="process-request.php" method="post">
                    <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                    <button type="submit" name="approve" <?php if ($row['status'] == "finished") echo "disabled";?>>Approve</button>
                    <button type="submit" name="reject" <?php if ($row['status'] == "finished") echo "disabled";?>>Reject</button>
                    <button type="submit" name="finish">Complete Rent</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
