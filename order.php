<?php
require_once 'header.php';
include 'buycalc.php';

if (isset($_POST['order'])) {
    $userid = $_SESSION['u_id'];
    $total = $_POST['sum'];
    $date = date("Y-m-d H:i:s");
    $sql = "SELECT * FROM user_addrs WHERE user_id='$userid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $useraddrid = $row['addr_id'];
            $sql1 = "SELECT * FROM credit_card WHERE user_id='$userid';";
            $result1 = $conn->query($sql1);
            if ($result1->num_rows > 0) {
                while($row = $result1->fetch_assoc()) {
                    //insert into orders
                    $sqlorders = "INSERT INTO  orders (user_id, o_date, total, addr_id)
                    VALUES ('$userid','$date','$total','$useraddrid');";
                    if ($conn->query($sqlorders) === TRUE) {
                        $last_id = $conn->insert_id;
                        $usersshopcartid = $_SESSION['u_shopcartid'];

                        $shopCartId = $_SESSION['u_shopcartid'];
                        if(isset($_SESSION['u_shopcartid'])) {
                            $shopCarts = "SELECT product_id, quantity, price FROM cart_item WHERE cart_id = '$shopCartId' ORDER BY cart_id DESC;";
                            $itemResult = $conn->query($shopCarts);
                            $inser = false;
                            if($itemResult->num_rows > 0) {
                                $items = [];
                                while($res = $itemResult->fetch_array()) {
                                    $items[] = $res;
                                }
                                foreach($items as $item) {
                                    $prod = $item['product_id'];
                                    $quantity = $item['quantity'];
                                    $price = $item['price'];
                                    $price = $price * $quantity;
                                    $sqlOrderItems = "INSERT INTO order_item (order_id, product_id, quantity, price)
                                        VALUES ('$last_id','$prod','$quantity', $price);";

                                    $sqlDelete = "DELETE FROM cart_item WHERE cart_id = '$shopCartId'";
                                    $conn->query($sqlDelete);
                                    if($conn->query($sqlOrderItems) === true)
                                        $insert = true;
                                }
                            } else {
                                $item = $itemResult->fetch_assoc();
                                $nalProd = $item['product_id'];
                                $quantity = $item['quantity'];
                                $sqlOrderItems = "INSERT INTO  order_item (order_id, product_id, quantity, price)
                                    VALUES ('$last_id','$nalProd','$quantity','$price');";
                                $insert = $conn->query($sqlOrderItems) === true ? true : false;

                                $sqlDelete = "DELETE FROM cart_item WHERE cart_id = '$shopCartId'";
                                $conn->query($sqlDelete);
                            }
                            if($insert) {
                                header("Location: cart.php");
                            }
                        }
                    } else {
                        echo "Error: ";
                    }
                }
            } else {
                //echo "0 results";
            }
        }
    } else {
        //echo "0 results";
    }
}
?>
