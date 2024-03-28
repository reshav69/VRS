<head>
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
</head>
<nav class="navbar">
    <div class="logo">VRS</div>

    <ul class="nav-links">

        <input type="checkbox" id="checkbox_toggle" />
        <label for="checkbox_toggle" class="hamburger">&#9776;</label>

        <div class="menu">

            <li><a href="user-dashboard.php">Home</a></li>
            <li><a href="about.html">About</a></li>


            <li><a href="#">Search</a></li>
            <li><a href="#">Contact</a></li>
            <!-- if user logged in show this -->
            <li class="categories">
                <a href="user-dashboard.php">| <?php echo $_SESSION['user-username']?> |</a>
                <ul class="dropdown">
                    <li><a href="#">Edit Profile? </a></li>
                    <li><a href="user-rented.php">My vehicles</a></li>
                    <li><a href="user-viewVehicles.php">Find Vehicles</a></li>
                    <li><a href="#">Dropdown 3</a></li>
                    <hr>
                    <li><a href="../functions/logout.php">logout</a></li>
                </ul>
            </li>
            <!-- else show signin/sign up -->
<!--             <li>Sign in</li>
            <li>Sign up</li> -->
        </div>
    </ul>
</nav>