<head>
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<nav class="navbar">
    <div class="logo"><a href="home.php">VRS</a></div>

    <ul class="nav-links">

        <input type="checkbox" id="checkbox_toggle" />
        <label for="checkbox_toggle" class="hamburger">&#9776;</label>

        <div class="menu">

            <li><a href="home.php">Home</a></li>
            <!-- <li><a href="#">About</a></li> -->


            <li><a href="user-viewVehicles.php">Find Vehicles</a></li>
            <!-- check loggedin -->
            <?php if (isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] === true) : ?>
            <li class="categories">
                <a href="user-dashboard.php">| <?php echo $_SESSION['user-username']?> |</a>
                <ul class="dropdown">
                    <li><a href="user-edit.php">Edit Profile? </a></li>
                    <li><a href="user-viewVehicles.php">Find Vehicles</a></li>
                    <li><a href="#">Dropdown 3</a></li>
                    <hr>
                    <li><a href="../functions/logout.php">logout</a></li>
                </ul>
            </li>
            <?php else : ?>
            <!-- else show signin/sign up -->
             <li><a href="user-login.php">Sign in</a></li>
            <li><a href="register.php">Sign up</a></li>
            <?php endif; ?>
        </div>
    </ul>
</nav>
