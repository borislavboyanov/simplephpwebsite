<?php include 'header.php';
if (isset($_POST['addtoshopcart']))
{
    $selectedname = $_POST['productidhidden'];
    $price = $_POST['productprice'];
    $quantity = $_POST['quant'];
    $usersshopcartid = $_SESSION['u_shopcartid'];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
                        $sql = "INSERT INTO cart_item (cart_id, product_id, quantity, price)
                        VALUES ('$usersshopcartid', '$selectedname', '$quantity', '$price');";
                        if ($conn->query($sql) === TRUE) {
                            header("Location: shoppingcart.php?add=success");
                        } else {  echo "Error: " . $sql . "<br>" . $conn->error;}
                    }

?>
