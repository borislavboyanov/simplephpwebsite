<?php
require_once 'dbconnection.php';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Начало</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <form class="" action="products.php" method="post">
            <a class="nav-link" href="products.php">Продукти <span class="sr-only">(current)</span></a>
        </form>

      </li>
    </ul>
    <?php
      if (isset($_SESSION['u_id'])) {
        $currentiduser = $_SESSION['u_id'];
        $sql = "SELECT * FROM shop_cart WHERE user_id='$currentiduser';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $_SESSION['u_shopcartid'] = $row['cart_id'];
            }
        } else {$sql1 = "INSERT INTO shop_cart (user_id) VALUES ('$currentiduser');";
                if ($conn->query($sql1) === TRUE) {
                $sql = "SELECT * FROM shop_cart WHERE user_id='$currentiduser';";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {$_SESSION['u_shopcartid'] = $row['cart_id'];}}
                }
        }
        echo '<form class="" action="logoutact.php" method="post">
        <div class="dropdown">
        <button class="btn btn-dark mr-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
        ."Добре дошли, ".$_SESSION['username']." ".
        '</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <h6 class="dropdown-header text-center">'.$_SESSION['first']." ".$_SESSION['last'].'</h6>
          <a class="dropdown-item" href="account.php">My Profile</a>

          <div class="dropdown-divider"></div>
          <button type="submit" name="logoutbutton" class="btn btn-danger btn-block rounded-0">Log Out</button>
        </div>
      </div></form>';
      } else {
        echo
        '  <a class="btn btn-primary" href="register.php" role="button">Регистрация</a>
          <a class="btn btn-primary" href="login.php" role="button">Вход</a>';

      }
     ?>

    <a class="shopping-cart text-dark ml-2" href="cart.php"><i class="fas fa-cart-arrow-down fa-2x"></i></a>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0 mx-2" type="submit">Search</button>
    </form>
  </div>
</nav>
