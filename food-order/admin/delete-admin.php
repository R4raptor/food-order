<?php
include("../config/constants.php");
// 1.get the id to be deleted
$id=$_GET['id'];

// 2.create SQl query to delte admin page
$sql ="DELETE FROM tbl_admin WHERE id=$id";
// Execute the query 
$res=mysqli_query($conn,$sql);
// 3.Redirec to manage Admin page with msg
if($res==true)
{
    // echo "Admin Deleted";
    $_SESSION['delete']="<div class='success'>Admin Deleted Successfully</div>";
    // Redirect To manage Admin Page
    header('location:'.SITEURL.'admin/manage-admin.php');
}else{
    // echo "Failed to Delete Admin";
    $_SESSION['delete']="<div class='error'>Failed to Delete Admin.Try Again Later.</div>";
    // Redirect To manage Admin Page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
?>
