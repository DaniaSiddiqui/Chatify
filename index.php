<?php

session_start();

include 'connection.php';
if (!isset($_SESSION['id'])) {
	header('location:signin.php');
} else {
	include 'header.php';
	$uid = $_SESSION['id'];
	$time = time() + 10;
	$res = mysqli_query($con,"UPDATE `signup` set `last_login` = '$time' where `user_id` = '$uid'");
	$chat_partner_name = ""; // Initialize the chat partner's name
?>

	<!-- Start of Add Friends -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="requests">
				<div class="title">
					<h1>Add your friends</h1>
					<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
				</div>
				<div class="content">
					<form id="submit-form" method="POST">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="user">Username:</label>
								</div>
								<div class="col-md-8">
									<div id='load-data'>
									</div>
								</div>
							</div>
							<input type="text" class="form-control" id="user" placeholder="Add recipient..." autocomplete="off" required>
						</div>

						<button type="submit" class="btn button w-100">Send Friend Request</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Add Friends -->
	<!-- Start of Create Chat -->
	<div class="modal fade" id="startnewchat" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="requests">
				<div class="title">
					<h1>Start new chat</h1>
					<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
				</div>
				<div class="content">
					<form method="post" id="sub-form">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="participant">Recipient:</label>
								</div>
								<div class="col-md-8">
									<div id='lodd-data'>
									</div>
								</div>
							</div>
							<input type="text" class="form-control" id="participant" placeholder="Send to..." autocomplete="off" required>
							<input type="hidden" class="form-control" id="login_user" value="<?php echo $_SESSION['name']; ?>">
						</div>
						<div class="form-group">
							<label for="message">Message:</label>
							<textarea class="text-control" id="message" placeholder="type your message..." autocomplete="off" required></textarea>
						</div>
						<button type="submit" class="btn button w-100">Send Message</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Create Chat -->
	<div class="main">
		<div class="tab-content" id="tab-pane fade">
			<!-- Start of Babble -->
			<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
				<!-- Start of Chat -->
				<div class="chat" id="chat1">
					<div class="top">
						<div class="container">
							<div class="col-md-12">
								<div class="inside">
									<?php
									// Assuming you have a database connection established as $con
									$name = $_SESSION['name'];
									$chat_partner_image = ""; // Initialize the chat partner's image

									if (isset($_GET['chat_partner'])) {
										$chat_partner_name = $_GET['chat_partner'];

										// Retrieve chat partner's image from the database (adjust this query based on your database structure)
										$image_query = "SELECT * from `signup` where `user_name` = '$chat_partner_name'";
										$image_result = mysqli_query($con, $image_query);

										if (mysqli_num_rows($image_result) > 0) {
											$image_row = mysqli_fetch_assoc($image_result);
											$chat_partner_image = $image_row['user_image'];
										}
									}
									?>
									<?php if (empty($chat_partner_name)) { ?>
										<p style="text-align: center; margin: 0; padding: 25%;">Please click on the chat preview messages to open a chat.</p>
									<?php } else { ?>
										<a href="#"><img class="avatar-md" src="<?php echo $chat_partner_image; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $chat_partner_name; ?>" alt="avatar"></a>
										
										<div class="data">
											<h5><a href="#"><?php echo $chat_partner_name; ?></a></h5>
											
										</div>

									

								</div>
							</div>
						</div>
					</div>
					<div class="content" id="content">
						<div class="container">
							<div class="col-md-12">
								<div class="date">
									<hr>
									<span>Yesterday</span>
									<hr>
								</div>
								<!-- Display messages for the selected chat partner (you need to implement this part) -->
								<?php

										// Retrieve and display messages for the selected chat partner (adjust this query based on your database structure)
										$messages_query = "SELECT * FROM messages WHERE (sender_username = '$name' AND receiver_username = '$chat_partner_name') OR (sender_username = '$chat_partner_name' AND receiver_username = '$name')";
										$messages_result = mysqli_query($con, $messages_query);
										$login_img = $_SESSION['img'];

										while ($message_row = mysqli_fetch_assoc($messages_result)) {
											$message_sender = $message_row['sender_username'];
											$message_text = $message_row['message_text'];
											$message_time = $message_row['dtetime'];
											$is_outgoing = ($message_sender === $name);
											$message_extension = pathinfo($message_text, PATHINFO_EXTENSION);
											// Extract and format the time
											$formatted_time = date("H:i:s", strtotime($message_time));

											// Determine the class for the message container based on the message sender
											$message_container_class = ($is_outgoing ? 'me' : 'you');
											$message_sender_image = ($is_outgoing ? $login_img : $chat_partner_image);
											$message_sender_name = ($is_outgoing ? $name : $chat_partner_name);

											$message_display_content = '';

											// Handle different file types based on the extension
											if (in_array($message_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
												$message_display_content = '<img src="' . $message_text . '" alt="Image" width="200" height="150">';
											} elseif ($message_extension === 'pdf') {
												$message_display_content = '<a href="' . $message_text . '" target="_blank">View PDF</a>';
											} else {
												$message_display_content = '<p>' . $message_text . '</p>';
											}
								?>
									<div class="message <?php echo $message_container_class; ?>">
										<img class="avatar-md" src="<?php echo $message_sender_image; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $message_sender_name; ?>" alt="avatar">
										<div class="text-main">
											<div class="text-group">
												<div class="text">
													<?php echo $message_display_content; ?>
												</div>
											</div>
											<span><?php echo $formatted_time; ?></span>
										</div>
									</div>
								<?php

										}
								?>



							</div>
						</div>
					</div>
					<div class="container">
						<div class="col-md-12">
							<div class="bottom">
								<form class="position-relative w-100" method="post" id="subm-form">
									<textarea class="form-control" id="msg" placeholder="Start typing for reply..." rows="1"></textarea>
									<input type="hidden" class="form-control" id="logind_user" value="<?php echo $_SESSION['name']; ?>">
									<input type="hidden" class="form-control" id="partner_name" value="<?php echo $chat_partner_name; ?>">
									<!-- <button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button> -->
									<button type="submit" class="btn send"><i class="material-icons">send</i></button>
								</form>
								<audio id="notificationSound" src="message_sound/message-sound.mp3"></audio>
								<form method="post" enctype="multipart/form-data">
									<label>
										<input type="file" id="input_file">
										<input type="hidden" class="form-control" id="login" value="<?php echo $_SESSION['name']; ?>">
										<input type="hidden" class="form-control" id="friend" value="<?php echo $chat_partner_name; ?>">
										<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
									</label>
								</form>
							</div>
						</div>
					</div>
				<?php
									}
				?>
				</div>
				<!-- End of Chat -->
			</div>
		</div>


	<?php
	include 'footer.php';
}
	?>