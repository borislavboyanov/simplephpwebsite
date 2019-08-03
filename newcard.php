<?php
    if (isset($_POST['submit'])) {

        $cardType = mysqli_real_escape_string($conn, $_POST['cardType']);
        $cardNum = mysqli_real_escape_string($conn, $_POST['cardNum']);
        $validUntil = mysqli_real_escape_string($conn, $_POST['validUntil']);
        $secCode = mysqli_real_escape_string($conn, $_POST['secCode']);

        if (empty($cardType) || empty($cardNum) || empty($validUntil) || empty($secCode))
        {
            header("Location: useraccount.php#v-pills-shipping?login=empty");
            exit();
        } else {
            $userid = $_SESSION['u_id'];
            $sql = "SELECT * FROM user_cards WHERE user_id='$userid'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck < 1)
            {
                $sql = "INSERT INTO user_cards (user_id, card_num, card_code, exp_date, card_default)
                        VALUES ('$userid', '$cardType', '$cardNum', '$secCode', '$validUntil', 1);";
                        mysqli_query($conn, $sql);
                        header("Location: useraccount.php?payment-added");
            } else {
                $sql = "INSERT INTO user_cards (user_id, card_type, card_num, card_code, exp_date, card_default)
                        VALUES ('$userid', '$cardType', '$cardNum', '$secCode', '$validUntil', 0);";
                        mysqli_query($conn, $sql);
                        header("Location: useraccount.php?payment-added");
            }
        }
    }
?>
