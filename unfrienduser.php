<?php
session_start();
include 'connection.php';

$login_user_name = $_POST['unfriend_by'];
$friend = $_POST['unfriend_to'];

   $find_id = mysqli_query($con,"SELECT `user_id` FROM `signup` where `user_name` = '$login_user_name'");
   $get = mysqli_fetch_assoc($find_id);
   $login_id = $get['user_id'];
   $find_id2 = mysqli_query($con,"SELECT `user_id` FROM `signup` where `user_name` = '$friend'");
   $get2 = mysqli_fetch_assoc($find_id2);
   $unfriend_id = $get['user_id'];
    $unfriend_user = mysqli_query($con,"DELETE FROM `contacts_table` where (`sender_name` = '$login_user_name' or `accepter_name` = '$login_user_name') and (`sender_name` = '$friend' or `accepter_name` = '$friend')"); 
    if($unfriend_user)
    {
        $update_notifications = mysqli_query($con, "UPDATE `notifications` SET `notification_msg` = 'unfriended',`notification_time` = 'false'  where (`user_id` = '$login_id' or `sender_id` = '$login_id') and (`user_id` = '$unfriend_id' or `sender_id` = '$unfriend_id') and `notification_time` = 'true'");
        if($update_notifications)
        {
            $update_friend_requests = mysqli_query($con, "UPDATE `friend_requests` SET `request_status` = 'unfriended' , `request_time` = 'false' , `unfriended_by` = '$login_user_name'  where (`send_by` = '$login_user_name' or `send_to` = '$login_user_name') and (`send_by` = '$friend' or `send_to` = '$friend')  and `request_time` = 'true'");
            if ($update_friend_requests) {
                $delete_messages = mysqli_query($con,"DELETE FROM `messages` where (`sender_username` = '$login_user_name' or `receiver_username` = '$login_user_name') and (`sender_username` = '$friend' or `receiver_username` = '$friend')");
                if($delete_messages)
                {
                     echo 1;
                }
                else {
                    echo mysqli_error($con);
                }
            }
            else {
                echo mysqli_error($con);
            }
        }
        else {
            echo mysqli_error($con);
        }
       
    }
    else {
        echo mysqli_error($con);
    }


?>