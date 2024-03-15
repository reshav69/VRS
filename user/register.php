<?php 
include "../functions/validate.php";
include "../functions/check-availability.php";
//variables
$name =$username= $address = $contact = $email = $password = "";
$name_err=$username_err = $address_err = $contact_err = $email_err = $password_err = "";
$errcnt=0;

// validate andget data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//check empty fields

	if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
        $errcnt++;
    } else {
        $name = trim($_POST["name"]);
	    //validating
	    if (validate_data($name, /*regexfor name*/ ) == false) {
	    	$name_err="The name should not contain numbers or special characters";
	    	$errcnt++;
	    }
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your name.";
        $errcnt++;
    } else {
        $username = trim($_POST["username"]);
    	if (validate_data($username, /*regexfor username*/ ) == false) {
	    	$name_err="Username invalid";
	    	$errcnt++;
	    }
    }

    // Validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter your address.";
        $errcnt++;
    } else {
        $address = trim($_POST["address"]);
    }

    // Validate contact
    if (empty(trim($_POST["contact"]))) {
        $contact_err = "Please enter your contact number.";
        $errcnt++;
    } else {
        $contact = trim($_POST["contact"]);
        if (validate_data($username, /*regex for contact*/ ) == false) {
	    	$contact_err="phone number invalids";
	    	$errcnt++;
	    }
    }

    //validate email
    $email = $_POST["email"];
	if (empty(trim($email))) {
	    $email_err = "Please enter your email address.";
	    $errcnt++;
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    $email_err = "Invalid email format.";
	    $errcnt++;
	}

	// Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
        $errcnt++;
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }


	//insert data
	if ($errcnt == 0) {
		$sql = "INSERT INTO Users (name,username,password,address,contact,email) VALUES(?,?,?,?,?,?)";

		//prepare statement
		if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name,$param_uname, $param_address, $param_contact, $param_email, $param_password);

            $param_name = $name;
            $param_uname = $username;
            $param_address = $address;
            $param_contact = $contact;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);//hash password

            // execute
            if (mysqli_stmt_execute($stmt)) {
            	echo "User registered redirecting ...";
            	sleep(3);
                header("location: user-login.php");
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
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span><?php echo $name_err; ?></span>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
            <span><?php echo $username_err; ?></span>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" value="<?php echo $address; ?>">
            <span><?php echo $address_err; ?></span>
        </div>
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" value="<?php echo $contact; ?>">
            <span><?php echo $contact_err; ?></span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password">
            <span><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" value="Register">
        </div>
        <p>Already have an account? <a href="user-login.php">Login here</a>.</p>
    </form>
</body>
</html>
