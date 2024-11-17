<?php include('partials/menu.php') ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <br>
        <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
            // removing session msg
        }

        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter Your Username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php') ?>


<?php 
// Process the value
// Check the button is clicked
if(isset($_POST['submit'])){
    // button Clicked
    // echo "Button Clicked";
    // get the data from form
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    $password=md5($_POST['password']); 

    // sql query to enter the data
    $sql="INSERT INTO tbl_admin SET
    full_name='$full_name',
    username='$username',
    password='$password'
    ";
    //  executing query and saving data into database
    $res=mysqli_query($conn,$sql);
    if($res==TRUE)
    {
        // Data Inserted
        // echo "Data Inserted";
        // Creste the variable to display msg
        $_SESSION['add']="<div class='success'>Admin Added Successfully</div>";
        // Redirrc the page to manage to Manage Admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }else{
        // Failed to Insert Data
        // echo "Failed to Insert Data";
        $_SESSION['add']="<div class='error'>Failed to Add Admin</div>";
        // Redirrc the page to Add Admin
        header("location:".SITEURL.'admin/add-admin.php');
    }
}
?>