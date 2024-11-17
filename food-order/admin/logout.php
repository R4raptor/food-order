<?php 
include('../config/constants.php');
// Destrory the seesion and redriectt to ligin page 
session_destroy();
// unset session and user
header('location:'.SITEURL.'admin/login.php');
?>