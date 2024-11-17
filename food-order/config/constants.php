<?php
// Start the session
session_start();
    // excute query and save database
    // $conn=mysqli_connect('localhost','root','',3307) or die(mysqli_error());
    // $db_select=mysqli_select_db($conn,'food-order') or die(mysqli_error());
// $servername = "localhost";
// $username ="root";
// $password="";
// $dbname = "food-order";

define('SITEURL','http://localhost:84/food-order/');
define('LOCALHOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','food-order');

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD,DB_NAME,3307);

if($conn)
{
    //  echo "connection ok";
    }
    else
    {
     echo "connection failed".mysqli_connect_error();
    }
    // $res=mysqli_query($conn,$sql) or die(mysqli_error());
?>