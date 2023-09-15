<?php
session_start();
include 'connection.php';

$user = $_POST['search'];
$loggined_user = isset($_SESSION['name']) ? $_SESSION['name'] : false;

if ($loggined_user != false) {
    $output = "";
    
    $sql_contacts = mysqli_query($con, "SELECT * FROM `contacts_table` WHERE (`sender_name` = '$user' AND `accepter_name` = '$_SESSION[name]') OR (`sender_name` = '$_SESSION[name]' AND `accepter_name` = '$user')");
    
    if (mysqli_num_rows($sql_contacts) > 0) {
        $data = mysqli_fetch_assoc($sql_contacts);
        $contactName = "";
        $contactImage = "";
        $isFriend = false;

        if ($data['sender_name'] == $_SESSION['name']) {
            $contactName = $data['accepter_name'];
            $contactImage = $data['accepter_image'];
            $isFriend = true;
        } elseif ($data['accepter_name'] == $_SESSION['name']) {
            $contactName = $data['sender_name'];
            $contactImage = $data['sender_image'];
            $isFriend = true;
        }

        if ($isFriend) {
            $output .= "
                <a href='#' class='filterMembers all offline contact' data-toggle='list'>
                    <img class='avatar-md' src='$contactImage' data-toggle='tooltip' data-placement='top' title='$contactName' alt='avatar'>
                    <div class='status'>
                        <i class='material-icons offline'>fiber_manual_record</i>
                    </div>
                    <div class='data'>
                        <h5>$contactName</h5>
                        <p>Friends</p>
                    </div>
                    <div class='person-add'>
                        <button class='btn btn-sm rounded-pill text-light bg-danger' id='unfriend' data-login-user='{$_SESSION['name']}' data-friend-id='$contactName'>Unfriend</button>
                    </div>
                </a>
            ";
        }
    } else {
        $sql_signup = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_name` = '$user'");
        
        if (mysqli_num_rows($sql_signup) > 0) {
            $data = mysqli_fetch_assoc($sql_signup);
            $signupUsername = $data['user_name'];
            $signupUserImage = $data['user_image'];

            if ($signupUsername != $_SESSION['name']) {
                $output .= "
                   
                    <a href='#' class='filterMembers all offline contact' data-toggle='list'>
                        <img class='avatar-md' src='$signupUserImage' data-toggle='tooltip' data-placement='top' title='$signupUsername' alt='avatar'>
                        <div class='status'>
                            <i class='material-icons offline'>fiber_manual_record</i>
                        </div>
                        <div class='data'>
                            <h5>$signupUsername</h5>
                            <p>Not Friends</p>
                        </div>
                        <div class='person-add'>
                        
                        <button class='btn btn-md rounded-pill text-light bg-success addFriendBtn' id='addFriend' data-friend-id='$signupUsername'>
                        Add
                        </button>
                        
                        </div>
                    </a>
                ";
            }
        } else {
            $output = "<p>No such user found</p>";
        }
    }

    echo $output;
} else {
    echo "<script>alert('Login First');</script>";
}
?>
