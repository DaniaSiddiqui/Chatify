<?php
session_start();
include 'connection.php';
$loggined = $_POST['loggined'];
$_SESSION['send_to_id'] = "";
$query = mysqli_query($con, "SELECT * from `signup` where `user_name` = '$loggined'");
$rows = mysqli_num_rows($query);
$select = "";
$user_id = $_SESSION['id'];
if (isset($_SESSION['name'])) {


    // $updated = mysqli_query($con, "UPDATE `signup` set `account_status` = 'deleted' where `user_name` = '$loggined'");
    $updated = mysqli_query($con, "DELETE FROM signup where  user_id = $user_id");
    if ($updated) {
        echo 1;
    } else {
        echo mysqli_error($con);
    }
} else {
    echo "Please Login First";
}
