<?php
  session_start();
  if (isset($_POST['loginbutton']))
  {
      include 'dbconnection.php';
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM users WHERE email='$email' OR password= '$password'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1)
        {
            header("Location: index.php?login=LoginDoesntExist");
            exit();
        }
        else {
            if ($row = mysqli_fetch_assoc($result))
            {
                //De-hashing
                $hashedPwdCheck = password_verify($password, $row['password']);
                if ($hashedPwdCheck == false)
                {
                    header("Location: index.php?login=WrongPassword");
                    exit();
                }
                elseif ($hashedPwdCheck == true) {
                    //Log in the user
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['first'] = $row['first'];
                    $_SESSION['last'] = $row['last'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['admin'] = $row['isadmin'];
                    $_SESSION['private'] = $row['isprivate'];
                    header("Location: index.php?login=success");
                    exit();
                }
            }
        }
      }
    else {
      header("Location: index.php");
      exit();
  }
