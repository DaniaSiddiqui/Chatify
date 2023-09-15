<?php
include 'connection.php';

$friend = $_POST['friend'];
$login = $_POST['login_user'];
$msg = $_POST['msg'];
date_default_timezone_set('Asia/Karachi');
$currentDateTime = new DateTime();
$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

$check_user = mysqli_query($con, "SELECT * FROM `friend_requests` WHERE (`send_by` = '$login' OR `send_to` = '$login') AND (`send_to` = '$friend' OR `send_by` = '$friend') AND `request_status` = 'accepted'");
$rows = mysqli_num_rows($check_user);
$check_user2 = mysqli_query($con, "SELECT * FROM `friend_requests` WHERE (`send_by` = '$login' OR `send_to` = '$login') AND (`send_to` = '$friend' OR `send_by` = '$friend') AND `request_status` = 'pending'");
$rows2 = mysqli_num_rows($check_user2);

if ($rows > 0) {
    $select = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_name` = '$friend' AND `user_name` != '$login'");
    $num_rows = mysqli_num_rows($select);
    if ($num_rows > 0) {
        $insert_msg = mysqli_query($con, "INSERT INTO `messages` (`sender_username`, `receiver_username`, `message_text`, `dtetime`) VALUES ('$login', '$friend', '$msg', '$formattedDateTime')");
        if ($insert_msg) {
            echo 1;
        } else {
            echo mysqli_error($con);
        }
    }
    else {
        echo " No such user found ";
    }
} elseif ($rows2 > 0) {
    echo "$friend is not your friend";
} else {
    echo "$friend is not your friend";
}
