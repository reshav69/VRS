<?php
session_start();

// Check if admin is not logged in, if not, redirect to admin login page
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}

include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        $request_id = $_POST['request_id'];

        // Update approved status and availability
        $sql = "UPDATE Rent SET status = 'approved' WHERE request_id = '$request_id';
        UPDATE Vehicles SET availability = 0 WHERE vehicle_id = (
            SELECT vehicle_id 
            FROM Rent 
            WHERE request_id = '$request_id'
        )";

        if (mysqli_multi_query($conn, $sql)) {
            echo "<script>alert('The request was approved');document.location='admin-rentRequests.php'</script>";
        } else {
            echo "Error approving rent request: " . mysqli_error($conn);
        }


    }

    // check reject
    if (isset($_POST['reject'])) {
        $request_id = $_POST['request_id'];

        // Update reject status
        $fsql = "UPDATE Rent SET status='rejected' WHERE request_id = '$request_id';
        UPDATE Vehicles SET availability = 1 WHERE vehicle_id = (
            SELECT vehicle_id 
            FROM Rent 
            WHERE request_id = '$request_id'
        )";
        if (mysqli_multi_query($conn, $fsql)) {
            echo "<script>alert('The request is rejected');document.location='admin-rentRequests.php'</script>";
        } else {
            echo "Error approving rent request: ";
        }
    }

    if (isset($_POST['finish'])) {
        $request_id = $_POST['request_id'];
        $fsql = "UPDATE Rent SET status='finished' WHERE request_id = '$request_id';
        UPDATE Vehicles SET availability = 1 WHERE vehicle_id = (
            SELECT vehicle_id 
            FROM Rent 
            WHERE request_id = '$request_id'
        )";

        if (mysqli_multi_query($conn, $fsql)) {
            echo "<script>alert('The request is now complete');document.location='admin-rentRequests.php'</script>";
        } else {
            echo "Error approving rent request: ";
        }
        
    }
}

// Close connection
mysqli_close($conn);
echo "OK!!! ";

echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
?>
