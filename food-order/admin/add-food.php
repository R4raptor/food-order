<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php
    if(isset($_SESSION['upload']))
    {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="Title of the Food">

                </td>
            </tr>
            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                </td>
            </tr>
            <tr>
                <td>Price: </td>
                <td><input type="number" name="price"></td>
            </tr>
            <tr>
                <td>Select Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                    <?php
                    // create Php code to diapay categories from Database
                    //1. create sql to get all active categories from database
                    $sql="SELECT * FROM tbl_category WHERE active='Yes' ";

                    // excuting query
                    $res=mysqli_query($conn,$sql);
                    //count rows to check if we have categories or not
                    $count=mysqli_num_rows($res);
                    //if we have categories then we will show them in dropdown
                    if($count>0)
                    {
                        // We have categories
                        while($row=mysqli_fetch_assoc($res))
                        {
                            // gte the detilas
                            $id=$row['id'];
                            $title=$row['title'];
                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php
                        }
                    }else{
                        // we do not have caegory 
                        ?>
                        <option value="0">No Category Found</option>
                        <?php
                    }
                    // 2. Display on Dropdown

                    ?>

                    </select>
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
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>
        <?php
    // check wheteher the button is clicked or not
    if(isset($_POST['submit']))
    {
        // add the food in the databse
        // echo "Clicked";

        // 1. Get the data from form
        $title = $_POST['title'];
        $description=$_POST['description'];
        $price=$_POST['price'];
        $category=$_POST['category'];
        // whether radio button active button is aactive or not
        if(isset($_POST['featured']))
        {
            $featured=$_POST['featured'];
        }else{
            $featured="No";
        }
        if(isset($_POST['active']))
        {
            $active=$_POST['active'];
        }else{
            $active="No";
        }
        // 2.upload te image if selected
        if(isset($_FILES['image']['name']))
        {
            // get the edetails of tthe selected image
            $image_name=$_FILES['image']['name'];
            // check imgae is selected or not nd upload only if seleceted
            if($image_name!="")
            {
                // Image is selected
                // A. Rename the image
                $ext=end(explode('.',$image_name));

                // create new name for the image
                $image_name="Food-Name-".rand(0000,9999).".".$ext;

                // B. upload the Image
                // get the sorece and setination path
                // source pathi is current location
                $src=$_FILES['image']['tmp_name'];

                // Destination path for the image to be uploaded
                $dst="../images/food/".$image_name;
                // finally upload image 
                $upload=move_uploaded_file($src,$dst);
                // check whether image is upload or not 
                if($upload==false)
                {
                    // failed to upload the image

                    // redirect to add feature page with error msg
                    $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    // stop the process 
                    die();
                }
            }
        }else{
            // setting default value as null
            $image_name="";
        }
        //3. insert into databse
        $sql2="INSERT INTO tbl_food SET
        title='$title',
        description='$description',
        -- for numerical value we dont need quotion
        price=$price,
        image_name='$image_name',
        category_id='$category',
        featured='$featured',
        active='$active'
        ";
        $res2=mysqli_query($conn,$sql2);
        // check whether data inserted or not
        //4. redirect the msg
        if($res2==true)
        {
            // Data inserted successfully
            $_SESSION['add']="<div class='success'>Food added Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }else{
            // failed to insert 
            $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        
    }
        ?>
    </div>
</div>

<?php include('partials/footer.php') ?>
