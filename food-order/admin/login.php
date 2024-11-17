<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login -Food Oder System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1><br><br>
        <?php
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?><br><br>
        <!-- form starts here -->
         <form action="" method="post" class="text-center">
            Username:
            <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>
            Password:
            <br><input type="password" name="password" placeholder="Enter Password"><br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
         </form>
        <!-- form ends here -->
        <p class="text-center">Created By - <a href="#">Harsh</a></p>
    </div>
</body>
</html>

<?php
if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password=md5($_POST['password']);
    // sql to check where the user with user name r passowrd exist or not 
    $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' ";

    $res=mysqli_query($conn,$sql);
    $count=mysqli_num_rows($res);
    if($count==1)
    {
        $_SESSION['login']="<div class='success'>Login Successful</div>";
        $_SESSION['user']=$username;
        // Redirect to Home Page /Dashboard
        header('location:'.SITEURL.'admin/');
    }
    else{
        
        $_SESSION['login']="<div class='error text-center'>Login Failed</div>";
        // Redirect to Home Page /Dashboard
        header('location:'.SITEURL.'admin/login.php');
    }
}
?>