<?php
// echo "delete Page";
include('../config/constants.php');
if(isset($_GET['id']) && isset($_GET['image_name']))
{
// echo "Process to delete";
// 1. Get ID and Image Name
$id=$_GET['id'];
$image_name=$_GET['image_name'];
// 2. Remove the Image if avaialable
// check Whether the image is avaialble or not and delee only if available
if($image_name !="")
{
    // it has mage and need to remove from folder
    // get the image path
    $path="../images/food/".$image_name;
    // Remove image file from the folder
    $remove=unlink($path);
    // checked wthere the image is removed or not 
    if($remove==false)
    {
        // Failed to remove image 
        $_SESSION['upload']="<div class='error'>Failed to Remove Image File.</div>";
        // redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
        // stop the process of deleting food 
        die();
    }
}
// 3. Delete Food from Dattabase
$sql="DELETE FROM tbl_food WHERE id=$id";
// Edceute the query
$res=mysqli_query($conn,$sql);
// check the query execuuted or not
if($res==true){
// 4. redirectt to manage food with sessin msg
$_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
header('location:'.SITEURL.'admin/manage-food.php');
}else{
    // redirect to manage food with sessin msg
    $_SESSION['delete']="<div class='error'>Failed to Delete Food.</div>";
header('location:'.SITEURL.'admin/manage-food.php');
}
}
else{
// echo "redirect";
$_SESSION['unauthorized']="<div class='error'>Unauthorized Acess.</div>";
header('location:'.SITEURL.'admin/manage-food.php');
}
?>