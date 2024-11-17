<?php 
    // check the user is login or not
    if(!isset($_SESSION['user']))
    {
        $_SESSION['no-login-message']="<div class='error text-center'>Please Login to access Admin Panel.</div>";
        // redirect to login page
        header('location:'.SITEURL.'admin/login.php');
        }
?>