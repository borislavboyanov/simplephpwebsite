<?php require_once 'header.php';

if(isset($_POST['adminedit'])) {
  $userid = $_POST['userid'];
$first = $_POST['first'];
$last = $_POST['last'];
$email = $_POST['email'];
$username = $_POST['username'];

if(isset($_POST['adcheckbox']))
$adcheckbox = 1;
else $adcheckbox = 0;

if(isset($_POST['licheckbox']))
$licheckbox = 1;
else $licheckbox = 0;

$sql = "UPDATE users SET first='$first', last='$last', username='$username', email='$email', isadmin='$adcheckbox', isprivate='$licheckbox' WHERE users.user_id='$userid'";
$update = $conn->query($sql);
header('account.php');

}

if(isset($_POST['delacc']) && isset($_POST['userid'])) {
  $userid = $_POST['userid'];
  $sql = "DELETE FROM shop_cart WHERE shop_cart.user_id=$'$userid'";
  $result = $conn->query($sql);
  $sql = "DELETE FROM users WHERE users.user_id='$userid'";
  $result = $conn->query($sql);
  $sql = "DELETE FROM credit_card WHERE credit_card.user_id=$userid";
  $result = $conn->query($sql);
  $sql = "DELETE FROM orders WHERE orders.user_id='$userid'";
  $result = $conn->query($sql);
  $sql = "DELETE FROM user_addrs WHERE user_addrs.user_id='$userid'";
  $result = $conn->query($sql);

  header("account.php");
}

?>

</body>
</html>
