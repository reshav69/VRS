<?php
session_start();

if (!isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] !== true) {
    header("location: user-login.php");
    exit();
}
include '../connection.php';

// Retrieve all vehicles from the database
$sql = "SELECT * FROM Vehicles";
$result = mysqli_query($conn, $sql);

// Close connection
mysqli_close($conn);
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
    <?php include 'user-nav.php';?>
    <h2>View Vehicles</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Mileage</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Image</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><a href="user-vehicle.php?id=<?php echo $row['vehicle_id']; ?>"><?php echo $row['name']; ?></a></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['mileage']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['availability'] ? 'Available' : 'Not Available'; ?></td>
                <td><img src="../vehicleImages/<?php echo $row['image_filename']; ?>" alt="Vehicle Image" style="max-width: 100px;"></td>

            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
