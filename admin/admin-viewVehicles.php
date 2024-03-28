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
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include 'admin-nav.php'?>
    <h2>View Vehicles</h2>
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
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['availability'] ? 'Available' : 'Not Available'; ?></td>
                <td><img src="../vehicleImages/<?php echo $row['image_filename']; ?>" alt="Vehicle Image" style="max-width: 100px;"></td>
                <td>
                    <!-- Edit button -->
                    <a href="admin-editVehicles.php?id=<?php echo $row['vehicle_id']; ?>">Edit</a>
                    <!-- Delete button -->
                    <a href="admin-deleteVehicle.php?id=<?php echo $row['vehicle_id']; ?>" onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
