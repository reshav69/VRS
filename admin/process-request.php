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

        // Update approved status
        $sql = "UPDATE Rent SET status = 'approved' WHERE request_id = ?";
        $usql = "UPDATE Vehcle SET availability = 0 WHERE request_id= '$request_id'";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $request_id);
            if (mysqli_stmt_execute($stmt)) {
                echo "Rent request approved successfully.";
            } else {
                echo "Error approving rent request.";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

    }

    // check reject
    if (isset($_POST['reject'])) {
        $request_id = $_POST['request_id'];

        // Update reject status
        $sql = "UPDATE Rent SET status = 'rejected' WHERE request_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $request_id);
            if (mysqli_stmt_execute($stmt)) {
                echo "Rent request rejected successfully.";
            } else {
                echo "Error rejecting rent request.";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}

// Close connection
mysqli_close($conn);
echo "OK!!! ";

echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
?>
