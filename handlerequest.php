<?php
session_start();
include 'connection.php';
$status = $_POST['request_status'];
$sended_to = $_POST['sended_to'];
$sended_by = $_POST['sended_by'];

$sender = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_id` = '$sended_by'");
$fetch = mysqli_fetch_assoc($sender);
$accepter = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_id` = '$sended_to'");
$fetch2 = mysqli_fetch_assoc($accepter);
if($fetch && $fetch2)
{
    $sender_name = $fetch['user_name'];
    $sender_img = $fetch['user_image'];
    $accepter_name = $fetch2['user_name'];
    $accepter_img = $fetch2['user_image'];
    $fetch_image = $fetch['user_image'];
        if ($status == "accepted") {
            $insert_contact = mysqli_query($con, "INSERT INTO `contacts_table` (`sender_id`,`accepter_id`,`sender_image`,`accepter_image`,`sender_name`,`accepter_name`) VALUES ('$sended_by','$sended_to','$sender_img','$accepter_img','$sender_name','$accepter_name')");
            if ($insert_contact) {
                $update_notifications = mysqli_query($con, "UPDATE `notifications` SET `notification_msg` = 'accepted' where `user_id` = '$sended_by' and `sender_id` = '$sended_to' and `notification_time` = 'true'");
                if ($update_notifications) {
                    $update_friend_requests = mysqli_query($con, "UPDATE `friend_requests` SET `request_status` = 'accepted'  where `send_by` = '$sender_name' and `send_to` = '$accepter_name' and `request_time` = 'true'");
                    if ($update_friend_requests) {
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
        }
        elseif ($status == "decline") {
             $delete_notification = mysqli_query($con,"UPDATE `notifications` SET `notification_msg` = 'declined' , `notification_time` = 'false' WHERE `user_id` = '$sended_by' AND `sender_id` = '$sended_to'");
             if($delete_notification)
             {
                $delete_request = mysqli_query($con,"UPDATE `friend_requests` SET `request_status` = 'declined' , `request_time` = 'false' where `send_by` = '$sender_name' and `send_to` = '$accepter_name'");
                if($delete_request)
                {
                    echo "You have declined this request";
                }
                else {
                    echo mysqli_error($con);
                }
             }
             else {
                echo mysqli_error($con);
             }
        }
    
}
else {
    echo "error in query";
}
