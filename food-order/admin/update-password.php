<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td><input type="password" name="current_password" placeholder="Current Password"></td>
                </tr>

                <tr>
                    <td>New Password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" class="btn-secondary" value="Change Password">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php 
    // check where the sumbit btn is clicked 
    if(isset($_POST['submit']))
    {
        $id=$_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        $sql="SELECT * FROM tbl_admin WHERE id='$id' AND password='$current_password' ";
        $res=mysqli_query($conn,$sql);
        if($res==true)
        {
            $count=mysqli_num_rows($res);
            if($count==1)
            {
                // echo "User Found";
                // check hether new passowrd and confirm match or not
                if($new_password==$confirm_password)
                {
                    // update passowrd
                    $sql2="UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id
                    ";
                    // Excute the query
                    $res2=mysqli_query($conn,$sql2);
                    if($res2==true)
                    {
                        // Display Success msg
                        $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else{
                        // Display false 
                        $_SESSION['change-pwd']="<div class='error'>Passowrd Changed Failed.</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else{
                    // redirect to manage admin pag with error msg
                    $_SESSION['pwd-not-match']="<div class='error'>Passowrd Doesn't match</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }else{
                $_SESSION['user-not-found']="<div class='error'>User Not Found</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
    }
?>

<?php include('partials/footer.php') ?>