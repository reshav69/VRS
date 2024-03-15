<?php 
require_once("../connection.php");
// code user username availablity

if(!empty(isset($_POST['username'])) && isset($_POST['username'])){

   $usernameInput= $_POST['username'];
   checkUsername($conn, $usernameInput);
  
}

function checkUsername($conn, $usernameInput){

  $query = "SELECT username FROM users WHERE username='$usernameInput'";
  $result = mysqli_query($conn,$query);
  if (mysqli_num_rows($result) > 0) {
    echo "<span style='color:red'>This username is taken. Try another</span>";
  }else{
    echo "<span style='color:green'>This username is available</span>";
  }
}