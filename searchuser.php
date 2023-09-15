<?php 
session_start();
include 'connection.php';
$user = $_POST['friend'];
$login = $_POST['login_user'];


$check_user = mysqli_query($con, "SELECT * FROM `friend_requests` WHERE (`send_by` = '$login' OR `send_to` = '$login') AND (`send_to` = '$user' OR `send_by` = '$user') AND `request_status` = 'accepted'");
$rows = mysqli_num_rows($check_user);
$check_user2 = mysqli_query($con, "SELECT * FROM `friend_requests` WHERE (`send_by` = '$login' OR `send_to` = '$login') AND (`send_to` = '$user' OR `send_by` = '$user') AND `request_status` = 'pending'");
$rows2 = mysqli_num_rows($check_user2);

if ($rows > 0) {
    $output = "";
    $select = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_name` = '$user' AND `user_name` != '$login'");
    $num_rows = mysqli_num_rows($select);
    
    if ($num_rows > 0) {
            while ($row = mysqli_fetch_assoc($select)) {
                $output .= "
                <div class='user' id='contact' style='width:100% bottom:0px;'>
                <img class='avatar-md' id='user_img' src=$row[user_image]  alt='avatar'>
                <h5>$row[user_name]</h5>
                <button class='btn'><i class='material-icons'>close</i></button>
                </div>
                ";
            }
            echo $output;
           
    } else {
        echo "<h6 style='color :red ;'> No such user found </h6>";
    }

    
} elseif ($rows2 > 0) {
    echo "<h6 style='color :red ;'>$user is not your friend</h6>";
} else {
    echo "<h6 style='color :red ;'>$user is not your friend</h6>";
}
?>
