<?php 
session_start();

//check session
// Check if admin is not logged in
if (!isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] !== true) {
    header("location: admin-login.php");
    exit();
}
$aid = $_SESSION['admin_id'];
//variables
$name =$model= $type = $mileage = $price = $vimage = $desc=$success="";
$name_err = $model_err = $type_err = $mileage_err = $price_err = $vimage_err =$err= "";
$errcnt = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//VALIDATE empty
	if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the name of the vehicle.";
        $errcnt++;
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["model"]))) {
        $model_err = "Please enter the model of the vehicle.";
        $errcnt++;
    } else {
        $model = trim($_POST["model"]);
    }

    if (empty(($_POST["type"]))) {
        $type_err = "Please select the type of the vehicle.";
        $errcnt++;
    } else {
        $type = ($_POST["type"]);
    }

    $desc=trim($_POST["desc"]);

    if (empty(trim($_POST["mileage"]))) {
        $mileage_err = "Please enter the mileage of the vehicle.";
        $errcnt++;
    } else {
        $mileage = trim($_POST["mileage"]);
    }

    if (empty(trim($_POST["price"]))) {
        $price_err = "Please enter the price of the vehicle.";
        $errcnt++;
    } else {
        $price = trim($_POST["price"]);
    }

    // upload image
    if ($_FILES['vimage']['error'] == 0) {
        if ($_FILES['vimage']['size'] < 1048576) { // 1MB limit
            $filetype = ['image/jpeg', 'image/png', 'image/webp'];
            if (in_array($_FILES['vimage']['type'], $filetype)) {
                $filename = uniqid() . '_' . $_FILES['vimage']['name'];
                $filepath = '../vehicleImages/' . $filename;
                if (move_uploaded_file($_FILES['vimage']['tmp_name'], $filepath)) {
                    $vimage = $filename; // Store filename in $vimage variable
                } else {
                    $vimage_err = 'Upload Failed';
                    $errcnt++;
                }
            } else {
                $vimage_err = 'File type must be JPG, PNG, or WEBP';
                $errcnt++;
            }
        } else {
            $vimage_err = 'File size must be less than 1MB';
            $errcnt++;
        }
    } else {
        $vimage_err = 'Choose file';
        $errcnt++;
    }

    if ($errcnt==0) {
        include '../connection.php';
        $sql = "INSERT INTO Vehicles (name,model, category, mileage, price,description, image_filename,aid) VALUES ( ?,?, ?, ?, ?, ?,?,?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_name,$param_model, $param_category, $param_mileage, $param_price,$param_desc, $param_vimage,$param_id);

            // Set parameters
            $param_name = $name;
            $param_model = $model;
            $param_category = $type;
            $param_mileage = $mileage;
            $param_price = $price;
            $param_desc = $desc; 
            $param_vimage = $vimage;
            $param_id = $aid;

            //execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $success= "Added successfully";
            } else {
                $err= "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add vehicle</title>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
    <?php include 'admin-nav.php'; ?>
    <?php echo '<p style="text-align:center;"class="error">'. $err .'</p>'; ?>
    <?php echo '<p style="text-align:center;"class="msg">'. $success .'</p>'; ?>
    <div class="form-container">
        <form action="admin-addVehicles.php" method="post" enctype="multipart/form-data">
            <div class="inp-grp">
                <label for="name">Vehicle Name: </label>
                <span class="inp-err"><?php echo $name_err; ?></span>
                <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
            </div>

            <div class="inp-grp">
                <label for="model">Vehicle model: </label>
                <span class="inp-err"><?php echo $model_err; ?></span>
                <input type="text" name="model" value="<?php echo isset($model) ? $model : ''; ?>">
            </div>

            <div class="inp-grp">
                <label for="desc">Vehicle desc: </label>
                <textarea name="desc" placeholder="Enter description" rows="5" cols="59"></textarea>
            </div>

            <div class="inp-grp">
                <label for="type">Vehicle Type: </label>
                <span class="inp-err"><?php echo $type_err; ?></span>
                <select name="type">
                    <option value="">--> Choose one <--</option>
                    <option value="Bicycle" <?php echo isset($type) && $type == 'Bicycle' ? 'selected' : ''; ?>>Bicycle</option>
                    <option value="Car" <?php echo isset($type) && $type == 'Car' ? 'selected' : ''; ?>>Car</option>
                    <option value="Motorcycle" <?php echo isset($type) && $type == 'Motorcycle' ? 'selected' : ''; ?>>Motorcycle</option>
                </select>
                
            </div>

            <div class="inp-grp">
                <label for="price">Price per day: </label>
                <span class="inp-err"><?php echo $price_err; ?></span>
                <input type="number" name="price" value="<?php echo isset($price) ? $price : ''; ?>">
            </div>

            <div class="inp-grp">
                <label for="mileage">Mileage: </label>
                <span class="inp-err"><?php echo $mileage_err; ?></span>
                <input type="number" name="mileage" value="<?php echo isset($mileage) ? $mileage : '';?>">
            </div>

            <div class="inp-grp">
                <label for="vimage">Upload image</label>
                <span class="inp-err"><?php echo $vimage_err; ?></span>
                <input type="file" name="vimage" id="vimage" />
            </div>

            <div class="inp-grp">
                <button type="submit" name="btnAdd" class="loginbtn">Add</button>
            </div>
        </form>
    </div>

</body>
</html>