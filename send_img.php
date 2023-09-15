<?php
include 'connection.php';

$img = $_FILES['image'];
$friend = $_POST['friend'];
$login = $_POST['login'];
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
        $imagename = $img['name'];
        $image_size = $img['size'];
        $extension = pathinfo($imagename, PATHINFO_EXTENSION);
        $format = array("jpeg", "pdf", "doc", "jpg", "png", "gif");
        if (in_array($extension, $format)) {
            if ($image_size <= 1000000) {
                $newname = rand() . "." . $extension;
                $folder = "images/" . $newname;
                if (strpos($folder, ' ') !== false) {
                    $folder = str_replace(' ', '', $folder);
                }
                $insert_img = mysqli_query($con, "INSERT INTO `messages` (`sender_username`, `receiver_username`, `message_text`, `dtetime`) VALUES ('$login', '$friend', '$folder', '$formattedDateTime')");
                if ($insert_img) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $folder)) {
                        echo 1;
                    } else {
                        echo "Cannot Upload File";
                    }
                } else {
                    echo mysqli_error($con);
                }
            } else {
                echo "Image should be less than 1Mb";
            }
        } else {
            echo "Invalid Format";
        }
    } else {
        echo " No such user found ";
    }
} elseif ($rows2 > 0) {
    echo "$friend is not your friend";
} else {
    echo "$friend is not your friend";
}
