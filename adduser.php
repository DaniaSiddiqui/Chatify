<?php
session_start();
include 'connection.php';
$send_to = $_POST['username'];
$currentDate = date('Y-m-d');
$_SESSION['send_to_id'] = "";
$query = mysqli_query($con, "SELECT `user_id` from `signup` where `user_name` = '$send_to'");
$rows = mysqli_num_rows($query);
$select = "";
$user_id = $_SESSION['id'];
if (isset($_SESSION['name'])) {

    $send_by =  $_SESSION['name'];
    
        if ($send_by != $send_to) {
            $row = mysqli_fetch_assoc($query);
            $user_id_send = $row['user_id'];
            $select = mysqli_query($con, "INSERT INTO `friend_requests` (`send_by`,`send_to`,`request_status`,`unfriended_by`,`request_time`,`send_date`) VALUES ('$send_by','$send_to','pending','null','true','$currentDate')");
            if ($select) {
                $request_id = mysqli_insert_id($con);
                $notifications = mysqli_query($con, "INSERT INTO `notifications` (`user_id`,`sender_id`,`friend_request_id`,`notification_msg`,`notification_time`,`notification_date`) VALUES ('$user_id','$user_id_send','$request_id','pending','true','$currentDate')");
                if($notifications)
                {
                    echo "Successfully Send Friend Request";
                }
            } else {
                echo "Cannot send friend Request";
            }
        }
    
} else {
    echo "Please Login First";
}
