<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
    <h1>Manage Order</h1>
    <br>
    <br>
    <br>
    <?php 
        if(isset($_SESSION['update']))
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    ?>
    <br><br>
    <table class="tbl-full">
        <tr>
            <th>S. N.</th>
            <th>Food</th>
            <th>Price</th>
            <th>Qty.</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Cutomer Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    <?php 
    // GEt all the orders
    $sql="SELECT * FROM tbl_order ORDER BY id DESC";
    // excute query
    $res=mysqli_query($conn,$sql);
    // count the rows 
    $count=mysqli_num_rows($res);
    if($count>0)
    {
        // order available;
        while($row=mysqli_fetch_assoc($res))
        {
            // GEt all the order details
            $id=$row['id'];
            $food=$row['food'];
            $price=$row['price'];
            $qty=$row['qty'];
            $total=$row['total'];
            $order_date=$row['order_date'];
            $status=$row['status'];
            $customer_name=$row['customer_name'];
            $customer_contact=$row['customer_contact'];
            $customer_email=$row['customer_email'];
            $customer_address=$row['customer_address'];

            ?>
             <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $food; ?></td>
            <td><?php echo $price; ?></td>
            <td><?php echo $qty; ?></td>
            <td><?php echo $total; ?></td>
            <td><?php echo $order_date; ?></td>
            <td>
                <?php 
                if($status=="Ordered")
                {
                    echo "<label>$status</label>";
                }
                elseif($status=="On Delivery")
                {
                    echo "<label style='color:orange' >$status</label>";
                }
                elseif($status=="Delivered")
                {
                    echo "<label style='color:green' >$status</label>";
                }
                elseif($status=="Cancelled")
                {
                    echo "<label style='color:red' >$status</label>";
                }
                ?>
                </td>

            <td><?php echo $customer_name; ?></td>
            <td><?php echo $customer_contact; ?></td>
            <td><?php echo $customer_email; ?></td>
            <td><?php echo $customer_address; ?></td>
            <td>
            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>"class="btn-secondary" >Update Admin</a>
            
            </td>
        </tr>
            <?php
        }
    }else{
        // Order Not Available 
        echo "<tr><td colspan='12' colspan='12' >Orders Not Available.</td></tr>";
    }
    ?>
       
        
       
       

    </table>
    </div>
</div>

<?php include('partials/footer.php') ?>