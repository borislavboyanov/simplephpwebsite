<?php include_once 'header.php';
$conn->set_charset('utf8mb4');?>

<div class="container mt-3 py-3">
	<div class="row">
		<div class="col-3">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-myaccount-tab" data-toggle="pill" href="#v-pills-myaccount" role="tab" aria-controls="v-pills-myaccount">Лична информация</a>
        <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders">Поръчки</a>
        <a class="nav-link" id="v-pills-shipping-tab" data-toggle="pill" href="#v-pills-shipping" role="tab" aria-controls="v-pills-shipping">Адрес</a>
        <a class="nav-link" id="v-pills-security-tab" data-toggle="pill" href="#v-pills-security" role="tab" aria-controls="v-pills-security">Смяна на парола</a>
        <?php  $userid = $_SESSION['u_id'];
        $sql = "SELECT * FROM users WHERE user_id='$userid'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            if($row['isadmin'] == 1) { ?>
              <a class="nav-link" id="v-pills-admin-tab" data-toggle="pill" href="#v-pills-admin" role="tab" aria-controls="v-pills-admin">Администраторски настройки</a>;
          <?php  }
          }
        }
        ?>
			</div>
		</div>



    <div class="col-9">
		<div class="tab-content ml-3" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-myaccount" role="tabpanel" aria-labelledby="v-pills-myaccount-tab">
        <h1>Акаунт</h1>
        <div class="dropdown-divider"></div>
        <br>
        <form action="editinfo.php" method="post">
          <div class="form-group row">
            <label for="staticName" class="col-sm-2 col-form-label">Име</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext" name="firstinput" value="<?php echo $_SESSION['first']; ?>">
							<input type="text" class="form-control-plaintext" name="lastinput" value="<?php echo $_SESSION['last']; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" name="emailinput" value="<?php echo $_SESSION['email'] ?>">
            </div>
          </div>


          <div class="form-group" align="right"><button type="submit" name="editpersonsinfo" class="btn btn-dark">Редактиране</button></div>
          <br>
        </form>


          <h1>Адрес за доставка</h1>
          <div class="dropdown-divider"></div>
          <br>
          <div class="form-group row">
            <?php
            $userid = $_SESSION['u_id'];
            $sql = "SELECT * FROM user_addrs WHERE user_id='$userid'";
            $result = $conn->query($sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0)
            {
              while ($row = mysqli_fetch_assoc($result)) {
                $addr = $row["address"];
                $postc = $row["postcode"];
                $city = $row["city"];
                  echo "<div class='card mr-3 mb-4 ml-3' style='width: 15rem;'>
                      <div class='card-body'>
                      <h5 class='card-title'>Adress</h5>
                        <p class='card-text'>$addr</p>
                        <p class='card-text'>".$city.", ".$postc."</p>
                      </div>
                    </div>";

                }
              } else { echo "Няма вписан адрес!"; }
            ?>
          </div>
          <br>
          <h1>Методи на плащане</h1>
          <div class="dropdown-divider"></div>
          <br>
          <div class="form-group">
          <div class="row">
            <?php
            $userid = $_SESSION['u_id'];
            $sql = "SELECT * FROM credit_card WHERE user_id='$userid'";
            $result = $conn->query($sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0)
            {
              while ($row = mysqli_fetch_assoc($result)) {
                $def = $row['card_default'];
                $cnum = $row['card_num'];
                $newcnum = substr($cnum, -4);
                if ($def == 1) {
                echo "<div class='card mr-3 mb-4 ml-3' style='width: 15rem;'>
                      <div class='card-body'>
                        <h5 class='card-title'>Default Payment</h5>
                        <p class='card-text'>"."**** **** **** ".$newcnum."</p>
                      </div>
                    </div>";
                } else {
                  echo "<div class='card mr-3 mb-4 ml-3' style='width: 15rem;'>
                      <div class='card-body'>
                        <h5 class='card-title'>Other Payment</h5>
                        <p class='card-text'>".$cardh1." ".$cardh2."</p>
                        <p class='card-text'>"."**** **** **** ".$newcnum."</p>
                      </div>
                    </div>";
                }
              }
            } else { echo "Нямате регистрирана кредитна карта!"; }
          ?>
        </div></div>
      </div>
      <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
        <h1>Поръчки</h1>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Номер на поръчка</th>
              <th scope="col">Дата</th>
              <th scope="col">Плащане</th>
              <th scope="col">Доставка</th>
              <th scope="col">Цена</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $userid = $_SESSION['u_id'];
            $sql = "SELECT DISTINCT orders.order_id, orders.o_date, orders.total,
            user_addrs.address, user_addrs.postcode, user_addrs.city
            FROM orders
            JOIN user_addrs
            ON user_addrs.addr_id=orders.addr_id
            WHERE orders.user_id='$userid';";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0)
            {
              while ($row = mysqli_fetch_assoc($result)) { ?>
                <form action="orderdetails.php" method="post">
                <?php
                $order_id = $row['order_id'];
                $date = $row['o_date'];
                $cost = $row['total'];
                $address = $row['address'];
                $post_code = $row['postcode'];
                $city = $row['city']; ?>
                <tr>
                  <th scope="row">1</th>
                  <input type="hidden" name="detailid" value="<?php echo $order_id ?>">
                  <td><?php echo $order_id; ?></td>
                  <td><?php echo $date; ?></td>
                  <td><?php echo $cost;; ?></td>
                  <td><button type="submit" name="viewdetails" class="btn btn-secondary btn-sm">Детайли</button></td>
                </tr>
                </form>
              <?php }
            }
            ?>

          </tbody>
        </table>
      </div>


      <div class="tab-pane fade" id="v-pills-admin" role="tabpanel" aria-labelledby="v-pills-orders-tab">
        <h1>Поръчки</h1>
                <form action="admin.php" method="post">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Име</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>
                        <th scope="col">Админ</th>
                        <th scope="col">Лицензиран</th>
												<th scope="col">Изтриване</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM users WHERE user_id <> '1'";
                    $result = $conn->query($sql);
                    if(mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>
                          <th scope="col"><?php echo $row['user_id']-1; ?> </th>
                          <th scope="col"><input type="text" class="form-control" name="first" aria-describedby="emailHelp" value="<?php echo $row['first']; ?>" <?php if($_SESSION['admin'] == 0) echo 'readonly'; ?>></th>
                          <th scope="col"><input type="text" class="form-control" name="last" aria-describedby="emailHelp" value="<?php echo $row['last']; ?>" <?php if($_SESSION['admin'] == 0) echo 'readonly'; ?>></th>
                          <th scope="col"><input type="text" class="form-control" name="email" aria-describedby="emailHelp" value="<?php echo $row['email']; ?>" <?php if($_SESSION['admin'] == 0) echo 'readonly'; ?>></th>
                            <th scope="col"><input type="text" class="form-control" name="username" aria-describedby="emailHelp" value="<?php echo $row['username']; ?>" <?php if($_SESSION['admin'] == 0) echo 'readonly'; ?>></th>
                        <?php if($_SESSION['admin'] == 1) { ?>  <th scope="col"><input class="form-check-input" type="checkbox" name="adcheckbox" value=<?php echo $row['isadmin']; ?> <?php if($row['isadmin'] == 1) echo "checked"; ?>></th>
                            <label class="form-check-label" for="adcheckbox"><?php if($row['isadmin'] == 1) echo "Да"; else echo "Не"; ?></label></th>
                            <th scope="col"><input class="form-check-input" type="checkbox" name="licheckbox" value=<?php echo $row['isprivate']; ?> <?php if($row['isprivate'] == 1) echo "checked"; ?>>
                              <label class="form-check-label" for="licheckbox"><?php if($row['isprivate'] == 1) echo "Да"; else echo "Не"; ?></label></th>
															<th><button type="post" name="delacc" class="btn btn-danger" value="<?php $row['user_id']; ?>"><i class="fas fa-trash-alt"></i></button></th> <?php } ?>
															<input type="hidden" name="userid" value="<?php echo $row['user_id']; ?>">
                        </tr>

                    <?php  }
                    }

                    ?>
                    </tbody>
                  </table>

                  <button type="submit" name="adminedit" class="btn btn-secondary btn-sm">Редактирай</button>
                </form>


        </table>
      </div>


      <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
        <button type="button" class="btn btn-dark mb-3" data-toggle="modal" data-target="#addPaymentModal">Методи на плащане</button>
          <form action="newcard.php" method="post">
          <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Информация за плащане</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="input-group mb-3 col-6">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                      </div>
                      <input name="cardhold1" type="text" class="form-control" id="inputHolder1" placeholder="First Name">
                    </div>
                    <div class="input-group mb-3 col-6">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                      </div>
                      <input name="cardhold2" type="text" class="form-control" id="inputHolder2"  placeholder="Last Name">
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-group mb-3 col-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="far fa-credit-card"></i></span>
                      </div>
                      <input name="cardType" type="text" class="form-control" id="inputCardType" placeholder="Type">
                    </div>
                    <div class="input-group mb-3 col-8">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="far fa-credit-card"></i></span>
                      </div>
                      <input name="cardNum" type="text" class="form-control" id="inputCardNum"  placeholder="Card Number">
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-group mb-3 col-7">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input name="validUntil" type="text" class="form-control" id="inputValidUntil" placeholder="MM/YY">
                    </div>
                    <div class="input-group mb-3 col-5">
                      <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                      </div>
                      <input name="secCode" type="text" class="form-control" id="inputSecCode"  placeholder="Security Code">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="submit" class="btn btn-dark">Добави кредитна карта</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Card Holder</th>
                <th scope="col">Card Type</th>
                <th scope="col">Card Number</th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
      </div>
      <div class="tab-pane fade" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
        <button type="button" class="btn btn-dark mb-3" data-toggle="modal" data-target="#addAddressModal">Добави адрес</button>
        <form action="newaddress.php" method="post">
        <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Адрес</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-home"></i></span>
                  </div>
                  <input name="street" type="text" class="form-control" id="inputAddress" placeholder=Улица>
                </div>
                <div class="row">
                  <div class="input-group mb-3 col-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-home"></i></span>
                    </div>
                    <input name="city" type="text" class="form-control" id="inputCity" placeholder="Град">
                  </div>
                  <div class="input-group mb-3 col-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-home"></i></span>
                    </div>
                    <input name="zip" type="text" class="form-control" id="inputZip" placeholder="П.К.">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-dark">Добави адрес</button>
              </div>
            </div>
          </div>
        </div>
        </form>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Адрес</th>
              <th scope="col">Град</th>
              <th scope="col">Пощенски код</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          <?php
            $userid = $_SESSION['u_id'];
            $sql = "SELECT * FROM user_addrs WHERE user_id='$userid'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result)) { ?>
              <form action="editinfo.php" method="post">
              <tr>
                <input type="hidden" name="addrid" value="<?php echo $row['addr_id']; ?>">
                <td><?php echo $row['address'] ?></td>
                <td><?php echo $row['city'] ?></td>
                <td><?php echo $row['postcode'] ?></td>
                <td><button name="deleteaddr" type="submit" class="btn btn-danger">Изтриване</button></td>
                </tr>
                </form> <?php
              } ?>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="v-pills-security" role="tabpanel" aria-labelledby="v-pills-security-tab">
        <form action="editinfo.php" method="post" class="needs-validation" novalidate>
          <h1>Смяна на email</h1>
          <div class="dropdown-divider"></div>
          <br>
          <div class="form-group row">
            <label for="inputNewEmail" class="col-sm-3 col-form-label">Нов email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" name="inputNewEmail" id="inputNewEmail" placeholder="Email" required>
            </div>
            <div class="invalid-feedback">
                  Въведете валиден email.
              </div>
              <div class="valid-feedback">
                  Looks great!
              </div>
          </div>
          <div class="form-group row">
            <label for="inputConfirmPassword" class="col-sm-3 col-form-label">Въведете парола</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" name="inputConfirmPassword" id="inputConfirmPassword" placeholder="Парола" required>
            </div>
            <div class="invalid-feedback">
                  Въведете валиден email.
              </div>
              <div class="valid-feedback">
                  Looks great!
              </div>
          </div>
          <div class="form-group">
            <button type="submit" name="changeEmailSec" class="btn btn-dark float-right">Запазване</button>
          </div>
          <br>
          </form>
          <form action="editinfo.php" method="post" class="needs-validation" novalidate>
          <br>
          <h1>Смяна на парола</h1>
          <div class="dropdown-divider"></div>
          <br>
          <div class="form-group row">
            <label for="inputCPassword" class="col-sm-3 col-form-label">Текуща парола</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="inputCPassword" name="inputCPassword" placeholder="Password" required>
            </div>
            <div class="invalid-feedback">
                  Въведете валидна парола
              </div>
              <div class="valid-feedback">
                  Looks great!
              </div>
          </div>
          <div class="form-group row">
            <label for="inputNewPassword" class="col-sm-3 col-form-label">Нова парола</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword"  placeholder="Password" required>
            </div>
            <div class="invalid-feedback">
                  Въведете валидна парола
              </div>
              <div class="valid-feedback">
                  Looks great!
              </div>
          </div>
          <div class="form-group row">
            <label for="inputConfPassword" class="col-sm-3 col-form-label">Потвърдете парола</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="inputConfPassword" name="inputConfPassword" placeholder="Password" required>
            </div>
            <div class="invalid-feedback">
                  Въведете валидна парола
              </div>
              <div class="valid-feedback">
                  Looks great!
              </div>
          </div>
          <div class="form-group">
            <button type="submit" name="changePwdSec" class="btn btn-dark float-right">Запазване</button>
          </div>
          <br>
        </form>
      </div>
		</div>
    </div>
	</div>
</div>
<script>
// wire up shown event
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    console.log("tab shown...");
});

// read hash from page load and change tab
var hash = document.location.hash;
var prefix = "tab_";
if (hash) {
    $('.nav-pills a[href="'+hash.replace(prefix,"")+'"]').tab('show');
}
</script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
vent
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    console.log("tab shown...");
});

// read hash from page load and change tab
var hash = document.location.hash;
var prefix = "tab_";
if (hash) {
    $('.nav-pills a[href="'+hash.replace(prefix,"")+'"]').tab('show');
}
</script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<?php include 'footer.php'; ?>
