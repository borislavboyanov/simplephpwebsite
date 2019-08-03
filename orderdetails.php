<?php include_once 'header.php';
$conn->set_charset('utf8mb4'); ?>

<div class="container mt-3 pb-3 pt-3">
    <?php

    if (isset($_POST['viewdetails'])) {
        $orderiddetail = $_POST['detailid'];
        $sql = "SELECT orders.order_id, products.product_name, products.p_picture, order_item.quantity, orders.total, products.p_price
        FROM orders
        JOIN order_item
        ON orders.order_id=order_item.order_id
        JOIN products
        ON order_item.product_id=products.product_id
        WHERE orders.order_id='$orderiddetail';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0)
        {
          while ($row = mysqli_fetch_assoc($result)) {
            $productname = $row['product_name'];
            $pic = $row['p_picture'];
            $quantity = $row['quantity'];
            $total = $row['p_price'];
             ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9"><h5><?php echo $productname;?></h5>
                        <p><small class="text-muted"><?php echo "Количество: ".$quantity.", цена: ".$total*$quantity ?></small></p></div>
                    </div>
                </div>
            </div>
          <?php }
        }
    }
    ?>
</div>
</body>
</html>
