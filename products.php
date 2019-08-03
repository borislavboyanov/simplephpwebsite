<?php require_once 'header.php'; ?>
<div class="container">
  <div class="row">
  <?php
  $conn->set_charset('utf8mb4');
  $query = $conn->query("SELECT p.product_id, p.product_name, p.product_desc, p.p_picture, p.p_quantity, p.p_price, p.isdangerous, c.category_name
  FROM products p
  JOIN categories c
  ON p.category_id=c.category_id;");
  $rowCount = $query->num_rows;
  if($rowCount > 0){
              while($row = $query->fetch_assoc()){
                $pid = $row['product_id'];
                $pname = $row['product_name'];
                $pdesc = $row['product_desc'];
                $ppic = $row['p_picture'];
                $pquantity = $row['p_quantity'];
                $price = $row['p_price'];
                $isdang = $row['isdangerous'];
                $catname = $row['category_name'];
                echo "
                    <div class='card' style='width: 14rem;'>
                        <img class='card-img-top' src='$ppic' alt='Card image cap'>
                        <div class='card-body'>
                            <p class='card-text font-weight-bold'>".$pname."<br> <small class='text-muted'>".$pdesc."<br>
                            ".$price." лв."."</small></p>
                        </div>
                        <div class='card-footer'>
                            <form action='productpage.php' method='post'>
                            <button type='submit' name='viewitem' value='$pid' class='btn btn-dark btn-block'>Разгледай продукта</button>
                            </form>
                        </div>
                    </div>";
              }
          } ?>
</div></div>
  </body>
</html>
