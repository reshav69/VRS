<?php 
//check session
session_start();

// Check if admin is not logged in
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}

//include navbar

include '../connection.php';

//select query order by category
$sql = "SELECT * FROM Vehicles ORDER BY category";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicles</title>
    <link rel="stylesheet" href="../css/tables.css">

</head>
<body>
    <?php include 'admin-nav.php'?>
    <h2>View Vehicles</h2>
    <div class="tab-veh">
    <table>
        <tr>
            <th>Name</th>
            <th>Model</th>
            <th>Category</th>
            <th>Mileage</th>
            <th>Price</th>
            <th>Description</th>
            <th>Availability</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><a href="admin-vehicle.php?id=<?php echo $row['vehicle_id']; ?>"><?php echo $row['name']; ?></a></td>
                <td><?php echo $row['model']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['mileage']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><div><?php echo $row['description']; ?></div></td>
                <td><?php echo $row['availability'] ? 'Available' : 'Not Available'; ?></td>
                <td><img src="../vehicleImages/<?php echo $row['image_filename']; ?>" alt="Vehicle Image" style="max-width: 100px;"></td>
                <td>
                    <!-- Edit button -->
                    <a class="green" href="admin-editVehicles.php?id=<?php echo $row['vehicle_id']; ?>">Edit</a>
                    <!-- Delete button -->
                    <a class="red" href="admin-deleteVehicle.php?id=<?php echo $row['vehicle_id']; ?>" onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
</body>
</html>
