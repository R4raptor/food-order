<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>
        <?php
        // check whther is is set or not
        if(isset($_GET['id']))
        {
            // get the order Details
            $id=$_GET['id'];
            
            // Get all the details based on this id
            $sql="SELECT * FROM tbl_order WHERE id=$id ";
            // excute the query
            $res=mysqli_query($conn,$sql);
            // count rows
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                // Detail Availble
                $row=mysqli_fetch_assoc($res);
                $food=$row['food'];
                $price=$row['price'];
                $qty=$row['qty'];
                $status=$row['status'];
                $customer_name=$row['customer_name'];
                $customer_contact=$row['customer_contact'];
                $customer_email=$row['customer_email'];
                $customer_address=$row['customer_address'];
            }
            else{
                // detail not avaialble
                // reirect to manage order
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        }else{
            // redirect to manage order page
            header('location:'.SITEURL.'admin/manage-order.php');
        }
        ?>
        <form action="" method="post">
            <table class="tbl-30" >
            <tr>
                <td>Food Name</td>
                <td><b><?php echo $food; ?></b></td>
            </tr>
            <tr>
                <td>Price</td>
                <td>
                    <b>$ <?php echo $price; ?></b>
                </td>
            </tr>
            <tr>
                <td>Qty</td>
                <td>
                    <input type="number" name="qty" value="<?php echo $qty; ?>">
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <select name="status" >
                        <option <?php if($status=="Ordered"){echo "selected";} ?> value="ordered">Ordered</option>
                        <option <?php if($status=="On Delivery"){echo "selected";} ?>value="On Delivery">On Delivery</option>
                        <option <?php if($status=="Delivered"){echo "selected";} ?>value="Delivered">Delivered</option>
                        <option <?php if($status=="Cancelled"){echo "selected";} ?>value="Cancelled">Cancelled</option>

                    </select>
                </td>
            </tr>
            <tr>
                <td>Customer Name: </td>
                <td>
                    <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                </td>
            </tr>
            <tr>
                <td>Customer Contact: </td>
                <td>
                    <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                </td>
            </tr>
            <tr>
                <td>Customer Email: </td>
                <td>
                    <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                </td>
            </tr>
            <tr>
                <td>Customer Address: </td>
                <td>
                    <textarea name="customer_address" cols="30" rows="5"  id=""><?php echo $customer_address; ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" >
                    <input type="hidden" name="id" value="<?php echo $id; ?>" >
                    <input type="hidden" name="price" value="<?php echo $price; ?>" >
                    <input type="submit" name="submit" value="Update Order" class="btn-secondary" >
                </td>
            </tr>
            </table>
        </form>
        <?php
        // check update button is clicke dor not
        if(isset($_POST['submit']))
        {
            // echo "Clicked";
            // get all the values from form
            $id=$_POST['id'];
            $price=$_POST['price'];
            $qty=$_POST['qty'];
            $total=$price*$qty;
            $status=$_POST['status'];

            $customer_name=$_POST['customer_name'];
            $customer_contact=$_POST['customer_contact'];
            $customer_email=$_POST['customer_email'];
            $customer_address=$_POST['customer_address'];
            // update the values
            $sql2="UPDATE tbl_order SET
            qty=$qty,
            total=$total,
            status='$status',
            customer_name='cutomer_name',
            customer_contact='cutomer_contact',
            customer_email='$customer_email',
            customer_address='$customer_address'
            WHERE id=$id
            ";
            // excute the query
            $res2=mysqli_query($conn,$sql2);
            // check whther update dor not 
            // and redirect to manage order with message
            if($res2==true)
            {
                // updated 
                $_SESSION['update']="<div class='success' >Order Updated Succesfully.</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            }else{
                // Failed to Updaate
                $_SESSION['update']="<div class='error' >Failed to Update Order.</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>