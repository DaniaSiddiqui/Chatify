<?php
session_start();
include 'connection.php';

$id = $_SESSION['id'];

$update_name = empty($_POST['upname']) ? null : $_POST['upname'];
$update_email = empty($_POST['upemail']) ? null : $_POST['upemail'];
$update_pass = empty($_POST['uppass']) ? null : $_POST['uppass'];
$pass_hash = password_hash($update_pass,PASSWORD_DEFAULT); 
$update_image = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK ? $_FILES['image'] : null;

$update_query = "UPDATE `signup` SET ";
$update_fields = [];

if (!is_null($update_name)) {

    $update_fields[] = "`user_name` = '$update_name'";
    $oldid = $_SESSION['id'];
    $_SESSION['name'] = $update_name;
    $find_name = mysqli_query($con,"SELECT `user_name` FROM `signup` where `user_id` = '$id'");
    $get = mysqli_fetch_assoc($find_name);
    $oldname = $get['user_name'];
    $check = mysqli_query($con,"SELECT `sender_username`,`receiver_username` FROM `messages` where `sender_username` = '$oldname' or  `receiver_username` = '$oldname'");
    $up_fr_name = mysqli_query($con,"SELECT `send_by`,`send_to` FROM `friend_requests` where `send_by` = '$oldname' or `send_to` = '$oldname'");
    $up_con_name = mysqli_query($con,"SELECT `sender_name`,`accepter_name` FROM `contacts_table` where `sender_name` = '$oldname' or `accepter_name` = '$oldname'");
    if($check)
{
    while ($alldata = mysqli_fetch_assoc($check)) {
        if($alldata['sender_username'] == $oldname)
        {
            $update_sender = mysqli_query($con,"UPDATE `messages` set `sender_username` = '$update_name' where `sender_username` = '$oldname'");
        }
        elseif($alldata['receiver_username'] == $oldname)
        {
            $update_receiver = mysqli_query($con,"UPDATE `messages` set `receiver_username` = '$update_name' where `receiver_username` = '$oldname'");
        }
        else {
            echo mysqli_error($con);
        }
    }
}

if ($up_fr_name) {
    while ($alldata = mysqli_fetch_assoc($up_fr_name)) {
        if($alldata['send_by'] == $oldname)
        {
            $update_sender = mysqli_query($con,"UPDATE `friend_requests` set `send_by` = '$update_name' where `send_by` = '$oldname'");
        }
        elseif($alldata['send_to'] == $oldname)
        {
            $update_receiver = mysqli_query($con,"UPDATE `friend_requests` set `send_to` = '$update_name' where `send_to` = '$oldname'");
        }
        else {
            echo mysqli_error($con);
        }
    }
}

if ($up_con_name) {
    while ($alldata = mysqli_fetch_assoc($up_con_name)) {
        if($alldata['sender_name'] == $oldname)
        {
            $update_sender = mysqli_query($con,"UPDATE `contacts_table` set `sender_name` = '$update_name' where `sender_name` = '$oldname'");
        }
        elseif($alldata['accepter_name'] == $oldname)
        {
            $update_receiver = mysqli_query($con,"UPDATE `contacts_table` set `accepter_name` = '$update_name' where `accepter_name` = '$oldname'");
        }
        else {
            echo mysqli_error($con);
        }
    }
}

}

if (!is_null($update_email)) {
    $update_fields[] = "`user_email` = '$update_email'";
}

if (!is_null($update_pass)) {
    $update_fields[] = "`user_password` = '$pass_hash'";
}

if (!is_null($update_image)) {
    $image = $_FILES['image'];
    $imagename = $image['name'];
    $image_size = $image['size'];
    $extension = pathinfo($imagename, PATHINFO_EXTENSION);
    $format = array("jpeg", "jpg", "png", "gif");
    $find_img = mysqli_query($con,"SELECT * FROM `contacts_table` where `sender_id` = '$id' or `accepter_id` = '$id'");
    if (in_array($extension, $format)) {
        if ($image_size <= 1000000) {
            $newname = rand() . "." . $extension;
            $folder = "images/" . $newname;
            if (strpos($folder, ' ') !== false) {
                $folder = str_replace(' ', '', $folder);
            }
            if (move_uploaded_file($_FILES['image']['tmp_name'], $folder)) {
                if($find_img)
                {
                    while ($alldata = mysqli_fetch_assoc($find_img)) {
                        if($alldata['sender_id'] == $id)
                        {
                            $update_sender = mysqli_query($con,"UPDATE `contacts_table` set `sender_image` = '$folder'  where `sender_id` = '$id'");
                        }
                        elseif($alldata['accepter_id'] == $id)
                        {
                            $update_receiver = mysqli_query($con,"UPDATE `contacts_table` set `accepter_image` = '$folder' where `accepter_id` = '$id'");
                        }
                        else {
                            echo mysqli_error($con);
                        }
                    }
                }
                
                $update_fields[] = "`user_image` = '$folder'";
            }
            else {
                echo "Cannot Upload File";
            }
        }
        else {
            echo "Image should be less than 1Mb";
        }
    }
    else {
        echo "Invalid Format";
    }
   
}

if (!empty($update_fields)) {
    $update_query .= implode(", ", $update_fields);
    $update_query .= " WHERE `user_id` = '$id'";
    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        if (!is_null($update_image)) {
            echo "Image updated successfully!";
        } else {
            echo "Data updated successfully!";
        }
    } else {
        echo "Update failed: " . mysqli_error($con);;
    }
} else {
    echo "No data to update.";
}

mysqli_close($con);
?>
