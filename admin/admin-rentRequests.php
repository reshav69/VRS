<?php
session_start();


if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}

include '../connection.php';
include 'admin-nav.php';

//get all data from database
$sql = "SELECT Rent.request_id, Users.username, Vehicles.name, Rent.request_date, Rent.status
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
</head>
<body>
    <h2>Admin Requests</h2>
    <table border="1">
        <tr>
            <th>Request ID</th>
            <th>User</th>
            <th>Vehicle</th>
            <th>Request Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['request_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form action="process-request.php" method="post">
                        <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                        <button type="submit" name="approve">Approve</button>
                        <button type="submit" name="reject">Reject</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
