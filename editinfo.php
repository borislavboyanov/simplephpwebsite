<?php
require_once 'header.php';
$conn->set_charset('utf8mb4');
if (isset($_POST['deleteaddr'])) {
    $addrid = $_POST['addrid'];
    $userid = $_SESSION['u_id'];
    $sql = "DELETE FROM user_addrs WHERE addr_id='$addrid'";
    $result = $conn->query($sql);
    header("Location: account.php");
} ?>



<?php
    $user = $_SESSION['u_id'];
    if ($user) {
        if (isset($_POST['changeEmailSec']))
        {
          $newemail = $_POST['inputNewEmail'];
          $confpass = $_POST['inputConfirmPassword'];

          $passget = $conn->query("SELECT password FROM users WHERE user_id='$user'");
          $rowCount = $passget->num_rows;
          if($rowCount>0){
              while ($row = $passget->fetch_assoc()) {
              $hashedPwdCheck = password_verify($confpass, $row['password']);

              if ($hashedPwdCheck == true) {
                      $emailchange = $conn->query("UPDATE users SET email='$newemail' WHERE user_id='$user'");
                      session_destroy();
                        header("Location: index.php");
                        exit();
                    } else {
                        die("Грешна парола");
                    }
                }
                }
            }
        }
 else {
        header("Location: index.php");
        exit();
    }
?>

<?php
    $user = $_SESSION['u_id'];
    if ($user) {
        if (isset($_POST['changePwdSec']))
        {
            $currentpass = mysqli_real_escape_string($conn, $_POST['inputCPassword']);
            $newpass = mysqli_real_escape_string($conn, $_POST['inputNewPassword']);
            $confpass = mysqli_real_escape_string($conn, $_POST['inputConfPassword']);

            $passget = $conn->query("SELECT password FROM users WHERE user_id='$user'");
            $rowCount = $passget->num_rows;
            if($rowCount>0){
                while ($row = $passget->fetch_assoc()) {
                $hashedPwdCheck = password_verify($currentpass, $row['password']);

                if ($hashedPwdCheck == true) {
                    if ($newpass == $confpass) {
                        $hashedPwd = password_hash($confpass, PASSWORD_DEFAULT);
                        $passchange = $conn->query("UPDATE users SET password='$hashedPwd' WHERE user_id='$user'");
                        session_destroy();
                        header("Location: index.php?success");
                        exit();
                    } else {
                        die("Паролите не съвпадат");
                    }
                } else {
                    die ("Паролата е грешна!");
                }
            }
        }
    }
    } else {
        header("Location: index.php?fail");
        exit();
    }
?>

<?php
if(isset($_POST['editpersonsinfo'])) {
$id = $_SESSION['u_id'];
$first = $_POST['firstinput'];
$_SESSION['first'] = $first;
$last = $_POST['lastinput'];
$_SESSION['last'] = $last;
$email = $_POST['emailinput'];
$_SESSION['email'] = $email;
$sql = "UPDATE users SET first='$first', last='$last', email='$email' WHERE users.user_id='$id'";
$update = $conn->query($sql);
header('account.php');
}
?>
