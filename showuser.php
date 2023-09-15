<?php
session_start();
include 'connection.php';
$user = $_POST['user'];
$loggined_user = isset($_SESSION['name']) ? $_SESSION['name'] : false ;
if($loggined_user != false)
{
    $check_user = mysqli_query($con,"SELECT * FROM `friend_requests` WHERE (`send_by` =  '$loggined_user' or `send_to` = '$loggined_user') and (`send_to` = '$user' or `send_by` = '$user')  and `request_status` = 'accepted'");
    $rows = mysqli_num_rows($check_user);
    $check_user2 = mysqli_query($con,"SELECT * FROM `friend_requests` WHERE (`send_by` =  '$loggined_user' or `send_to` = '$loggined_user')  and `send_to` = '$user' and `request_status` = 'pending'");
    $rows2 = mysqli_num_rows($check_user2);
    if($rows > 0)
    {
        echo "<h6 style='color :red ;'>" .  $user . " is already your friend </h6>";
    }
    elseif($rows2 > 0)
    {
        echo "<h6 style='color :red ;'>" . " Request already in pending</h6>";
    }
    else {
        $select = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_name` = '$user' AND `user_name` != '$loggined_user'");
        $num_rows = mysqli_num_rows($select);
        $output = "";
        
        
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
                    echo "<h6 style='color :red ;'>No Such user Found</h6>";
                }
    }
   
    
}
else {
    echo "<script>alert('Login First');</script>";
}

?>