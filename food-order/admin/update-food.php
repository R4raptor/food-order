<?php include('partials/menu.php'); ?>

<?php
// check whether the id is set or not
if(isset($_GET['id']))
{
    // get all the details;
    $id=$_GET['id'];
    // SQL query to selcet the photo
    $sql2="SELECT * FROM tbl_food WHERE id=$id";
    // exceute the query 
    $res2=mysqli_query($conn,$sql2);
    // get the values based on query exceuted
    $row2=mysqli_fetch_assoc($res2);
    // gte the individula Value of selcted food
    $title=$row2['title'];
    $description =$row2['description'];
    $price=$row2['price'];
    $current_image=$row2['image_name'];
    $current_category=$row2['category_id'];
    $featured=$row2['featured'];
    $active=$row2['active'];
}else{
    // redirecting to manage food
    header('location:'.SITEURL.'admin/manage-food.php');

}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php 
                        if($current_image =="")
                        {
                            // Image not availble
                            echo"<div class='error'>Image Not Available.</div>";
                        }else{
                            // Image Available 
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px;" >
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" >
                            <?php 
                            // Query to active category
                            $sql="SELECT * FROM tbl_category WHERE active='Yes' ";
                            // Execute the query
                            $res=mysqli_query($conn,$sql);
                            // Count Rows
                            $count=mysqli_num_rows($res);
                            // check whether category available or not
                            if($count>0)
                            {
                                // category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title=$row['title'];
                                    $category_id=$row['id'];

                                    // echo "<option value='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }

                            }else{
                                // cateegory not avaiable
                                echo "<option value='0'>Category Not Available.</option>";
                            }
                            ?>
                            <option value="0">Test Category</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if(isset($_POST['submit']))
        {
            // echo "Button clicked";
            // 1. get all th details 
            $id=$_POST['id'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $current_image=$_POST['current_image'];
            $category=$_POST['category'];
            $featured=$_POST['featured'];
            $active=$_POST['active'];
            // 2. upload the image if selecefted
            // check whether upload button is clicke dor nnot
            if(isset($_FILES['image']['name']))
            {
                // upload dbutton is clicked
                $image_name=$_FILES['image']['name']; //new wimage name
                // chck whether the fie is available or not
                $ext=end(explode('.',$image_name));// gte the xetrniion of the image
                $image_name="Food-Name-".rand(0000,9999).".".$ext;// This will rename image
                // get the src and dest path
                $src_path=$_FILES['image']['tmp_name'];
                $dest_path="../images/food/".$image_name;
                $upload =move_uploaded_file($src_path,$dest_path);
                // check whetger the img is uploaded or not
                if($upload==false)
                {
                    $_SESSION['upload']="<div class='error'>Failed to Upload New Image.</div>";
                    // redirect to manage food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                    // stop the process
                    die();
                }
                // 3. remove the image if new image is uploaded and current image exists
                // B. Remove current Image if available
                if($current_image!="")
                {
                    // current Image i sAvailable
                    // remove the image
                    $remove_path="../images/food/".$current_image;
                    $remove=unlink($remove_path);
                    // check whther img is renove d
                    if($remove==false)
                    {
                        // faile dto remove current image
                        $_SESSION['remove-failed']="<div class='error'>Failed to remove current Image.</div>";
                        //redirect to manage food
                        header('location:'.SITEURL.'admin/manage-food.php');
                        // sop te process
                        die();
                    }
                }
                else{
                    $image_name=$current_image;//Deafult Image when Image is not selected
                }
            } else{
                $image_name=$current_image;//Defalut Image when Button is not clicked
            }
            
            // 4. Update the food in databse
            $sql3="UPDATE tbl_food SET
            title='$title',
            description='$description',
            price='$price',
            image_name='$image_name',
            category_id='$category',
            featured='$featured',
            active='$active'
            WHERE id=$id
            ";
            // ecute the sql query
            $res3=mysqli_query($conn,$sql3);
            // check hwther the query is eceuted  or not
            if($res3==true)
            {
                $_SESSION['update']="<div class='success'>Food Updated Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }else{
                $_SESSION['update']="<div class='error'>Failed to Update Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            // redircet to manage food with session msg
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>