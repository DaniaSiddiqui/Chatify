<?php
session_start();
include 'connection.php';

$msg = $_POST['search_message'];
$user_login = $_SESSION['name'];

$query = "SELECT 
    CASE 
        WHEN m.sender_username = '$user_login' THEN m.receiver_username
        ELSE m.sender_username
    END AS chat_partner,
    c.sender_image, c.accepter_image,
    m.dtetime AS message_time,
    m.sender_username AS message_sender,
    m.receiver_username AS message_receiver,
    m.message_text AS message
FROM messages m
INNER JOIN contacts_table c 
    ON (m.sender_username = c.sender_name AND m.receiver_username = c.accepter_name)
    OR (m.sender_username = c.accepter_name AND m.receiver_username = c.sender_name)
WHERE (m.sender_username = '$user_login' OR m.receiver_username = '$user_login') 
    AND (m.message_text LIKE '% $msg %' OR m.message_text LIKE '$msg %' OR m.message_text LIKE '% $msg')
ORDER BY m.dtetime ASC"; 

$message = mysqli_query($con, $query);

if (mysqli_num_rows($message) > 0) {
    while ($data = mysqli_fetch_assoc($message)) {
        $chat_partner_name = $data['chat_partner'];
        $chat_partner_image = ($data['message_sender'] == $user_login) ? $data['accepter_image'] : $data['sender_image'];
        
        $message_time = $data['message_time'];
        $message_text = $data['message'];
        
        // Determine whether the message was sent by the user or the friend
        $message_sent_by_user = ($data['message_sender'] == $user_login);

?>
        <!-- Your HTML output for each message -->
        <a href="index.php?chat_partner=<?php echo $chat_partner_name; ?>" class="filterDiscussions all unread single active">
            <img class="avatar-md" src="<?php echo $chat_partner_image; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $chat_partner_name; ?>" alt="avatar">
            <div class="data">
                <h5><?php echo $chat_partner_name; ?></h5>
                <span><?php echo $message_time; ?></span>
                <p style="margin: 0; padding: 5px; background-color: <?php echo $message_sent_by_user ? '#d6eaf8' : '#f4f4f4'; ?>; border-radius: 5px;">
                    <?php echo $message_text; ?>
                </p>
            </div>
        </a>
        <!-- End of your HTML output -->
<?php
    }
}
else {
    echo "<p>No such message</p>";
}
?>
