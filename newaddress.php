<?php require_once 'header.php';
    if (isset($_POST['submit'])) {
      $userid= $_SESSION['u_id'];
        $address = mysqli_real_escape_string($conn, $_POST['street']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $zip = mysqli_real_escape_string($conn, $_POST['zip']);
        if (empty($address) || empty($city) || empty($zip))
        {
            header("account.php");
        } else {
              $sql = "INSERT INTO user_addrs (user_id, address, postcode, city)
                        VALUES ('$userid', '$address', '$zip', '$city')";
                        $result = $conn->query($sql);
                        header("account.php?address-added");
            }
        }

?>
