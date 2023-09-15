<?php
session_start();
include 'connection.php';

$email = $_POST['email_id'];
$pass = $_POST['password'];
$remember = isset($_POST['remember_me']) ? true : false;

$_SESSION['login'] = false;

$sql = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_email` = '$email' and `account_status` != 'deleted'");
$num = mysqli_num_rows($sql);

if ($num > 0) {
    $fetch = mysqli_fetch_assoc($sql);

    if (password_verify($pass, $fetch['user_password'])) {
        $_SESSION['img'] = $fetch['user_image'];
        $_SESSION['name'] = $fetch['user_name'];
        $_SESSION['id'] = $fetch['user_id'];
        $_SESSION['login'] = true;

        if ($remember) {
            $encryptedPass = base64_encode($pass);
            setcookie('remember_email', $email, time() + 172800, '/');
            setcookie('password', $encryptedPass, time() + 172800, '/');
        } else {
            setcookie('remember_email', '', time() - 600000, '/');
            setcookie('password', '', time() - 600000, '/');
        }

        echo "Successfully Login";
    } else {
        echo "Invalid Password";
    }
} else {
    echo "Invalid Email";
}
?>
