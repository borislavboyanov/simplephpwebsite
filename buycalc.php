<?php require_once 'header.php';
if (isset($_POST['delfromcart'])) {


    $del = $_POST['cart_item_id'];
    $sql = "DELETE FROM cart_item WHERE cart_item.cart_item_id='$del';";
    $result = $conn->query($sql);
    header("Location: cart.php");
} ?>

<?php
if (isset($_POST['updateitemcart']))
{
    $del = $_POST['cart_item_id'];
    $q = $_POST['quantity_change'];
    $sql = "UPDATE cart_item SET quantity='$q' WHERE cart_item.cart_item_id='$del';";
    $result = $conn->query($sql);
    header("Location: cart.php");
 }
?>
