<?php 
// include constants file
include('../config/constants.php');

// echo "delete page"; 
// check whether the id and image_name value is sset or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // get the value and delete
    // echo"get value and delete";
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];
// remove the physical image file is avaialbe
if($image_name !="")
{
    // image avaialable
    $path="../images/category/".$image_name;
    $remove=unlink($path);
    // if failed to remove image add an error msg
    if($remove==false)
    {
        //set the session msg
        $_SESSION['remove']="<div class='error'>Failed to Remove Category Image.</div>";
        // redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
        //stop the process
        die();
    }
}
// delete data from dataabase
// sql query to delete data from database
$sql="DELETE FROM tbl_category WHERE id=$id";
// execute the query
$res=mysqli_query($conn,$sql);
// check whether the query is executed or not
if($res==true)
{
    // set success message and redirect
    $_SESSION['delete']="<div class='success'>Category Deleted Successfully.</div>";
    // redirect to manage category page
    header('location:'.SITEURL.'admin/manage-category.php');
}
else{
// set fail message and redirects
$_SESSION['delete']="<div class='error'>Failed to Delete Category.</div>";
// redirect to manage category page
header('location:'.SITEURL.'admin/manage-category.php');
}


}else{
    // redirect to manage category page
    header('location:'.SITEURL.'admin/manage-category.php');
}
?>