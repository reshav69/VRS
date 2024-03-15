<?php 
session_start();
//check session

//check login status
if (isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] === true) {
    header("location: user-dashboard.php");
    exit();
}
//include navbar

//variables
$username = $password = $password_err =$username_err = "";

//check credentials
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	//check emptys
	if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
        $errcnt++;
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
        $errcnt++;
    } else {
        $password = trim($_POST["password"]);
    }

    if ($errcnt == 0) {
    	include '../connection.php';
    	$sql = "SELECT user_id,username,password FROM Users WHERE username=?";

    	if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            // execute
            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                // Check if username exists
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password);
                    //fetch
                    if (mysqli_stmt_fetch($stmt)) {
                    	//verify hashed password
                        if (password_verify($password, $hashed_password)) {

                            // Store in session and send to dashboard
                            $_SESSION["user_logged_in"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["user-username"] = $username;

                            header("location: user-dashboard.php");
                            exit();
                        } else {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User login</title>
</head>
<body>
	<div class="form-container">
        <h2>Users Login</h2>
        <form action="admin-login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span class="error"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
	
</body>
</html>