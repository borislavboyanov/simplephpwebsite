<?php require_once 'header.php';
    if (isset($_POST['regsubmit'])) {

        $first = mysqli_real_escape_string($conn, $_POST['first']);
        $last = mysqli_real_escape_string($conn, $_POST['last']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);


            if (!preg_match("/^[a-zA-Z .-]*$/", $first) || !preg_match("/^[a-zA-Z .-]*$/", $last)) {
                header("Location: register.php?signup=invalid");
                exit();
            }
                else {

                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);

                    if ($resultCheck > 0) {
                        header("Location: register.php?signup=usertaken");
                        exit();
                    }
                    else {

                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                        $sql = "INSERT INTO users (first, last, username, password, email)
                        VALUES ('$first', '$last', '$username', '$hashedPwd', '$email');";
                        if ($conn->query($sql) === TRUE) {
                            $sql1 = "SELECT user_id FROM users WHERE email='$email';";
                            $result1 = $conn->query($sql1);
                            header("Location: register.php?signup=success");
                            exit();
                        }

                }
            }
        }
    else {
        header("Location: register.php?signup=error1");
        exit();
    }
?>
