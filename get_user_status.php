<?php
session_start();
include('connection.php');
$uid = $_SESSION['id'];
$time = time();
$res = mysqli_query($con, "SELECT * FROM `signup` where `user_id` != '$uid'");
$html = '';
while ($row = mysqli_fetch_assoc($res)) {
    $status = "offline";
    $class = "offline";
    if ($row['last_login'] > $time) {
        $status = "online";
        $class = "online";
    }
    $html .= '<i class="material-icons '.$class.'">fiber_manual_record</i>';
}
echo $html;
?>