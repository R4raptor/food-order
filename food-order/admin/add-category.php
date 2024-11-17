<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>
        <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        
        ?>
    <br><br>
        <!-- Add Category form starts -->
         <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
         </form>
        <!-- Add Category form ends -->
         <?php
        //  chcek the submit button is clicke dor not
        if(isset($_POST['submit']))
        {
            // echo "clicked";
            // get the value from the form 
            $title=$_POST['title'];

            // for radio input tag we need to check the button is selected or not 
            if(isset($_POST['featured']))
            {
                // Get the value from the form
                $featured=$_POST['featured'];
            }
            else{
                // Set the default value from the form 
                $featured="No";
            }
            if(isset($_POST['active']))
            {
                // Get the value from the form
                $active=$_POST['active'];
            }
            else{
                // Set the default value from the form 
                $active="No";
            }
            // Check image is selected or not
            // print_r($_FILES['image']);
            if(isset($_FILES['image']['name']))
            {
                // Get the image name from the form
                //to upload the image we need source path and destination path
                $image_name=$_FILES['image']['name'];

                // upload the imgae only if seletected
                if($image_name!="")
                {

                

                // Auto rename image
                // get the extenion of the img
                $ext=end(explode('.',$image_name));
                // rename the image
                $image_name="Food_Category_".rand(000,999).'.'.$ext;

                $source_path=$_FILES['image']['tmp_name'];
                $detination_path="../images/category/".$image_name;
                // Finally Upload the image 
                $upload=move_uploaded_file($source_path,$detination_path);
                // Check whether the image is uploaded or not
                // and if the image is not uploaded we will stop the process and redirect with tthe error msg
                if($upload==false)
                {
                    // set message
                    $_SESSION['upload']="<div class='error'>Failed to upload image. Please try again!</div>";
                    // redirect to add category page
                    header('location:'.SITEURL.'admin/add-category.php');
                    // stop the process
                    die();
                }
                }
            }
            else{
                // Set the default value from the form as blank and dont import
                $image_name="";
            }
             //Break the code here
            // create sql query to insert 
            $sql="INSERT INTO tbl_category SET
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            ";
            // excute the query and save in the db
            $res=mysqli_query($conn,$sql);
            // check whether the query excuted or not and data added or not
            if($res==true)
            {
                // query Executed and Category Added
                $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
                // Redirect to Manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else{
                // Failed to Add Category 
                $_SESSION['add']="<div class='error'>Failed to Add Category.</div>";
                // Redirect to Manage category page
                header('location:'.SITEURL.'admin/add-category.php');
            }
        }
        
         ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>