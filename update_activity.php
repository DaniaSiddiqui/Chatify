<?php 
session_start();
include('connection.php');
$uid = $_SESSION['id'];
$time = time() + 10;
$res = mysqli_query($con,"UPDATE `signup` set `last_login` = '$time' where `user_id` = '$uid'");
?>