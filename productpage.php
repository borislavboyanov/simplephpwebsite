<?php require_once 'header.php'; ?>

    <?php
      $conn->set_charset('utf8mb4');
        if (isset($_POST['viewitem']))
        {
            $viewitemid = $_POST['viewitem'];
            $sql = "SELECT p.product_id, p.product_name, p.product_desc, p.p_picture, p.p_quantity, p.p_price, p.isdangerous, c.category_name
            FROM products p
            JOIN categories c
            ON p.category_id=c.category_id
            WHERE p.product_id=$viewitemid";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0)
            {
                while ($row = mysqli_fetch_assoc($result)) {
                  $pid = $row['product_id'];
                  $pname = $row['product_name'];
                  $pdesc = $row['product_desc'];
                  $ppic = $row['p_picture'];
                  $pquantity = $row['p_quantity'];
                  $price = $row['p_price'];
                  $isdang = $row['isdangerous'];
                  $catname = $row['category_name'];
                }
            }
        }
    ?>
<form action="addtocart.php" class="needs-validation" novalidate method="post">
<div class='container mt-3'>
    <div class='row'>
        <div class='col-sm'>
            <img class='card-img-top my-3' src='<?php echo $ppic ?>' alt='Card image cap'>
        </div>
        <div class='col-sm'>
            <div class='container my-3'>
                <input type="hidden" id="productID" name="productidhidden" value="<?php echo $pid ?>">
                <input type="hidden" id="productprice" name="productprice" value="<?php echo $price ?>">
                <input type="number" id="qunt" name="quant" value="1">
                <div class='form-group'>
                    <h1><?php echo $pname ?></h1>
                </div>
                <div class="dropdown-divider"></div>
                <div class='form-group'>
                    <br>
                    <p><?php echo $pdesc ?></p>
                    <p class="text-right"><?php echo "Цена: ".$price." лв." ?></p>
                </div>
                <div class="dropdown-divider"></div>
                <div class='form-group'>
                <br>
                <div class='form-group'>
                    <button type="submit" name="addtoshopcart" class="btn btn-dark btn-block" <?php
                    if(($_SESSION['private'] == 0 || !isset($_SESSION['u_id'])) && $isdang == 1){
                     echo "disabled";
                     }
                     ?>>Добави в количката</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
