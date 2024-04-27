<?php 
include "../functions/validate.php";
// include "../functions/check-availability.php";
//variables
$name =$username= $address = $contact = $email = $password = "";
$name_err=$username_err = $address_err = $contact_err = $email_err = $password_err = "";
$errcnt=0;

// validate and get data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//check empty fields
	$name=trim($_POST["name"]);
	if (empty(($name))) {
        $name_err = "Please enter your name.";
        $errcnt++;
    } else {
	    //validating
       if (validate_data($name, '/^[a-zA-Z\s]+$/' ) === false) {
          $name_err="The name should not contain numbers or special characters";
          $errcnt++;
      }
  }

    // Validate username
  $username=trim($_POST["username"]);
  if (empty($username)) {
    $username_err = "Please enter your username.";
    $errcnt++;
} else {
   if (validate_data($username, '/^[A-Za-z][A-Za-z0-9]{4,29}$/' ) === false) {
      $username_err="Username invalid must be like 'test', 'test12'";
      $errcnt++;
  }
}

    // Validate address
$address=trim($_POST["address"]);
if (empty($address)) {
    $address_err = "Please enter your address.";
    $errcnt++;
} else {
    $address = trim($_POST["address"]);
}

    // Validate contact
$contact=trim($_POST["contact"]);
if (empty($contact)) {
    $contact_err = "Please enter your contact number.";
    $errcnt++;
} else {

    if (validate_data($contact, '/^9[0-9]{9}$/' ) == false) {
      $contact_err="phone number invalid";
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
  include "../connection.php";
  $sql = "INSERT INTO Users (name,username,password,address,contact,email) VALUES(?,?,?,?,?,?)";

		//prepare statement
  if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables
    mysqli_stmt_bind_param($stmt, "ssssss", $param_name,$param_uname, $param_password, $param_address, $param_contact, $param_email);

    $param_name = $name;
    $param_uname = $username;
    $param_address = $address;
    $param_contact = $contact;
    $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);//hash password

            // execute
            if (mysqli_stmt_execute($stmt)) {
                header("location: ./user-login.php");
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
    <link rel="stylesheet" type="text/css" href="../css/form.css">

</head>
<body>
    <?php include 'user-nav.php'; ?>
    <div class="form-container">
        <h2 align="center">User Registration</h2><hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="inp-grp">
                <label for="name">Name</label>
                <span class="error"><?php echo $name_err; ?></span>
                <input type="text" name="name" value="<?php echo $name; ?>">
            </div>
            <div class="inp-grp">
                <label for="username">Username</label>
                <span class="error"><?php echo $username_err; ?></span>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="inp-grp">
                <label for="address">Address</label>
                <span class="error"><?php echo $address_err; ?></span>
                <input type="text" name="address" value="<?php echo $address; ?>">
            </div>
            <div class="inp-grp">
                <label for="contact">Contact</label>
                <span class="error"><?php echo $contact_err; ?></span>
                <input type="text" name="contact" value="<?php echo $contact; ?>">
            </div>
            <div class="inp-grp">
                <label for="email">Email</label>
                <span class="error"><?php echo $email_err; ?></span>
                <input type="text" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="inp-grp">
                <label for="password">Password</label>
                <span class="error"><?php echo $password_err; ?></span>
                <input type="password" name="password">
            </div>
            <div class="inp-grp">
                <button name="submit" class="registerbtn">Register </button>
            </div>
            <p>Already have an account? <a href="user-login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
