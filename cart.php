<?php require_once 'header.php'; ?>


<div class="container mt-3">
    <div class="row">
        <div class="col-8">
        <br>
        <h1>Количка</h1>
        <br>
            <?php
            $conn->set_charset('utf8mb4');
                $usersshopcartid = $_SESSION['u_shopcartid'];
                $sql = "SELECT products.product_name, products.p_price, cart_item.quantity, cart_item.cart_item_id FROM products JOIN cart_item ON products.product_id = cart_item.product_id
                WHERE cart_item.cart_id = '$usersshopcartid'";
                $result = $conn->query($sql);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck > 0) {
                    while($row = $result->fetch_assoc()) {
                        $productname = $row['product_name'];
                        $quantity = $row['quantity'];
                        $price = $row['p_price'];
                        $shopcartitemid = $row['cart_item_id']; ?>
                        <form action="buycalc.php" method="post">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="cart_item_id" value="<?php echo $row['cart_item_id']; ?>"><?php echo $row['cart_item_id'];?>
                                    <input type="hidden" name="price" value="<?php echo $row['p_price']; ?>">
                                    <div class="col-7"><h5><?php echo $productname;?></h5>
                                    <div class="col-1"><input type="number" name="quantity_change" min="1" max="100" value="<?php echo $quantity ?>"></div>
                                    <div class="col-2"><p class="text-center"><?php echo ($price*$quantity)." лв."?></p></div>
                                    <div class="col-2"><button type="submit" name="updateitemcart" class="btn btn-success">Обнови</button><?php echo " " ?>
                                    <button type="submit" name="delfromcart" class="btn btn-danger">Изтрий</button></div>
                                </div>
                            </div>
                        </div></div></form>
                <?php }
                }
            ?>

<form action="order.php" method="post">
        <div class="col-4">
        <?php
            $result = $conn->query("SELECT quantity, price FROM cart_item WHERE cart_id='$usersshopcartid'");
            $columnValues = Array();
            while ( $row = $result->fetch_assoc() ) {
              $temp = $row['quantity']*$row['price'];
              array_push($columnValues, $temp);
            } $sum = array_sum($columnValues);
            ?>
            <br>
            <h1>Поръчка</h1>
            <br>
            <div class="container">
            <p class="text-right">Цена:<?php echo " ".$sum." лв." ?></p>
            <p class="text-right">Цена за доставка:<?php $delivery = 10; echo " ".$delivery." лв."; ?></p>
            <p class="text-right">Общо:<?php $total=$sum+$delivery;
            echo " ".number_format((float)$total, 2, '.', '')." лв"; ?></p>
            <input type="hidden" name="sum" value="<?php echo $sum ?>">
            <div class="dropdown-divider"></div>
            <br>
            <button type="submit" name="order" class="btn btn-dark btn-block">Поръчай</button>
            </div>

        </div>
        </form>
    </div>
    <br>
</div>
</div>

  </body>
</html>
