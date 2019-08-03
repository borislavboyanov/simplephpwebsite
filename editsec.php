<?php
    include 'dbconnection.php';
    session_start();
    $user = $_SESSION['u_id'];
    if ($user) {
        if (isset($_POST['changeEmailSec']))
        {
            $newemail = $_POST['inputNewEmail'];
            $confpass = $_POST['inputConfirmPassword'];

            $passget = $conn->query("SELECT user_pwd FROM users WHERE user_id='$user'");
            $rowCount = $passget->num_rows;
            if($rowCount>0){
                while ($row = $passget->fetch_assoc()) {
                $hashedPwdCheck = password_verify($confpass, $row['user_pwd']);

                if ($hashedPwdCheck == true) {
                        $emailchange = $conn->query("UPDATE users SET user_email='$confemail' WHERE user_id='$user'");
                        session_destroy();
                        header("Location: index.php");
                        exit();
                    } else {
                        die("Emails doesn't match");
                    }
                } else {
                    die ("This is not your email!");
                }
            }
        }
    }
    } else {
        header("Location: ../index.php");
        exit();
    }
?>

<?php
    include 'dbconnection.php';
    session_start();
    $user = $_SESSION['u_id'];
    if ($user) {
        if (isset($_POST['changePwdSec']))
        {
            $currentpass = mysqli_real_escape_string($conn, $_POST['inputCPassword']);
            $newpass = mysqli_real_escape_string($conn, $_POST['inputNewPassword']);
            $confpass = mysqli_real_escape_string($conn, $_POST['inputConfPassword']);

            $passget = $conn->query("SELECT user_pwd FROM users WHERE user_id='$user'");
            $rowCount = $passget->num_rows;
            if($rowCount>0){
                while ($row = $passget->fetch_assoc()) {
                $hashedPwdCheck = password_verify($currentpass, $row['user_pwd']);

                if ($hashedPwdCheck == true) {
                    if ($newpass == $confpass) {
                        $hashedPwd = password_hash($confpass, PASSWORD_DEFAULT);
                        $passchange = $conn->query("UPDATE users SET user_pwd='$hashedPwd' WHERE user_id='$user'");
                        session_destroy();
                        header("Location: index.php?success");
                        exit();
                    } else {
                        die("Emails doesn't match");
                    }
                } else {
                    die ("This is not your email!");
                }
            }
        }
    }
    } else {
        header("Location: index.php?fail");
        exit();
    }
?>
