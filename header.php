<?php
include 'connection.php';
if (session_id() == null) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Chatify – The Simplest Chat Platform</title>
	<meta name="description" content="#">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
	<!-- Swipe core CSS -->
	<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
	<!-- Favicon -->
	<link href="dist/img/favicon.png" type="image/png" rel="icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
	<main>
		<div class="layout">
			<!-- Start of Navigation -->
			<div class="navigation">
				<div class="container">
					<div class="inside">
						<div class="nav nav-tab menu">
							<button class="btn"><?php

												if (isset($_SESSION['id'])) {
													$id = $_SESSION['id'];
													$show_image = mysqli_query($con, "SELECT * FROM `signup` WHERE `user_id` = '$id'");
													$img = mysqli_fetch_assoc($show_image);
													$image = $img['user_image'];
													echo "<img class='avatar-xl' src='$image' alt='avatar'>";
												}
												?></button>
							<a href="#members" data-toggle="tab"><i class="material-icons">account_circle</i></a>
							<a href="#discussions" data-toggle="tab" class="active"><i class="material-icons active">chat_bubble_outline</i></a>
							<a href="#notifications" data-toggle="tab" class="f-grow1"><i class="material-icons">notifications_none</i></a>
							<a href="#settings" data-toggle="tab"><i class="material-icons">settings</i></a>
							<a href="logout.php" class="btn power"><i class="material-icons">power_settings_new</i></a>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Navigation -->
			<!-- Start of Sidebar -->
			<div class="sidebar" id="sidebar">
				<div class="container">
					<div class="col-md-12">
						<div class="tab-content">
							<!-- Start of Contacts -->
							<div class="tab-pane fade" id="members">
								<div class="search">
									<form class="form-inline position-relative" method="post">
										<input type="search" class="form-control" id="people" placeholder="Search for people..." autocomplete="off">
										<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
									</form>
									<button class="btn create" data-toggle="modal" data-target="#exampleModalCenter"><i class="material-icons">person_add</i></button>
								</div>
								<div class="list-group sort">
									<button class="btn filterMembersBtn active show" data-toggle="list" data-filter="all">All</button>
								</div>
								<div class="contacts">
									<h1>Contacts</h1>
									<div class="row">
										<div class="col-md-12">
											<div class="list-group" id="contactsContainer" role="tablist">
											</div>
										</div>
									</div>


									<div class="list-group" id="contacts" role="tablist">
										<?php
										$id = $_SESSION['id'];
										$sql = mysqli_query($con, "SELECT * FROM `contacts_table`");
										
										if (mysqli_num_rows($sql) > 0) {
											while ($data = mysqli_fetch_assoc($sql)) {

												if ($data['sender_id'] == $id) {
													
										?>
													<a href="#" class="filterMembers all  contact" data-toggle="list">
														<img class="avatar-md" src="<?php
																					echo $data['accepter_image'];
																					?>" data-toggle="tooltip" data-placement="top" title="<?php echo $data['accepter_name']; ?>" alt="avatar">

														
														<div class="data">
															<h5>
																<?php
																echo $data['accepter_name'];
																?>
															</h5>
															<p>Friends</p>
														</div>
														<div class="person-add">
															<button class="btn btn-sm rounded-pill text-light bg-danger" id="unfriend" data-login-user="<?php echo $_SESSION['name']; ?>" data-friend-id="<?php echo $data['accepter_name']; ?>">Unfriend</button>
														</div>
													</a>
												<?php
												} elseif ($data['accepter_id'] == $id) {
												?>
													<a href="#" class="filterMembers all  contact" data-toggle="list">
														<img class="avatar-md" src="<?php
																					echo $data['sender_image'];
																					?>" data-toggle="tooltip" data-placement="top" title="<?php
																																			echo $data['sender_name'];
																																			?>" alt="avatar">
														
														<div class="data">
															<h5>
																<?php
																echo $data['sender_name'];
																?>
															</h5>
															<p>Friends</p>
														</div>
														<div class="person-add">
															<button class="btn btn-sm rounded-pill text-light bg-danger" id="unfriend" data-login-user="<?php echo $_SESSION['name']; ?>" data-friend-id="<?php echo $data['sender_name']; ?>">Unfriend</button>
														</div>
													</a>
										<?php
												}
											}
										} 

										?>
										
											
									</div>
								</div>
							</div>
							<!-- End of Contacts -->
							<!-- Start of Discussions -->
							<div id="discussions" class="tab-pane fade active show">
								<div class="search">
									<form class="form-inline position-relative" method="post">
										<input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
										<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
									</form>
									<button class="btn create" data-toggle="modal" data-target="#startnewchat"><i class="material-icons">create</i></button>
								</div>
								<div class="list-group sort">
									<button class="btn filterDiscussionsBtn active show" data-toggle="list" data-filter="all">All</button>
								</div>
								<div class="discussions">
									<h1>Messages</h1>
									<div class="row">
										<div class="col-md-12">
											<div class="list-group" id="messagesContainer" role="tablist">
											</div>
										</div>
									</div>
									<div class="list-group" id="chats" role="tablist">
										<?php
										$name = $_SESSION['name'];

										$query = "SELECT DISTINCT 
                CASE 
                    WHEN m.sender_username = '$name' THEN m.receiver_username
                    ELSE m.sender_username
                END AS chat_partner,
                c.sender_image, c.accepter_image,
                MAX(m.dtetime) AS last_message_time,
                MAX(m.sender_username = '$name') AS is_outgoing,
                MAX(m.dtetime) AS last_message_time,
                MAX(m.message_text) AS last_message
              FROM messages m
              INNER JOIN contacts_table c 
              ON (m.sender_username = c.sender_name AND m.receiver_username = c.accepter_name)
                 OR (m.sender_username = c.accepter_name AND m.receiver_username = c.sender_name)
              WHERE c.sender_name = '$name' OR c.accepter_name = '$name'
              GROUP BY chat_partner";

										$result = mysqli_query($con, $query);
										$chat_partner_image = ""; // Initialize the chat partner's image
										if (mysqli_num_rows($result) > 0) {
											while ($row = mysqli_fetch_assoc($result)) {
												$chat_partner_name = $row['chat_partner'];
												$image_query = "SELECT * from `signup` where `user_name` = '$chat_partner_name'";
												$image_result = mysqli_query($con, $image_query);
												if (mysqli_num_rows($image_result) > 0) {
													$image_row = mysqli_fetch_assoc($image_result);
													$chat_partner_image = $image_row['user_image'];
												}
												$last_message_time = $row['last_message_time'];
												$last_message = $row['last_message'];
												$is_outgoing = $row['is_outgoing'];
												// Apply different styling for outgoing messages
												$message_class = $is_outgoing ? "outgoing-message" : "";
										?>

												<!-- Now you can use $initial_status in your HTML code -->

												

												<a href="index.php?chat_partner=<?php echo $chat_partner_name; ?>" class="filterDiscussions all unread single active">
													<img class="avatar-md" src="<?php echo $chat_partner_image; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $chat_partner_name; ?>" alt="avatar">
													
													<div class="data <?php echo $message_class; ?>">
														<h5><?php echo $chat_partner_name; ?></h5>
														<span><?php echo $last_message_time; ?></span>
														<p><?php echo $last_message; ?></p>
													</div>
												</a>

											<?php
											}
										} else {
											?>
											<div class="data mt-3">
												<h5>No chats to show</h5>
											</div>
										<?php
										}
										?>
									</div>


								</div>
							</div>
							<!-- End of Discussions -->
							<!-- Start of Notifications -->
							<div id="notifications" class="tab-pane fade">
								<div class="search">
									<form class="form-inline position-relative">
										<input type="search" class="form-control" id="notice" placeholder="Filter notifications...">
										<button type="button" class="btn btn-link loop"><i class="material-icons filter-list">filter_list</i></button>
									</form>
								</div>
								<div class="list-group sort">
									<button class="btn filterNotificationsBtn active show" data-toggle="list" data-filter="all">All</button>

								</div>
								<div class="notifications">
									<h1>Notifications</h1>
									<?php

									$user_id = $_SESSION['id'];
									$user_name = $_SESSION['name'];
									$check_request = mysqli_query($con, "SELECT * FROM `friend_requests` WHERE `send_to` = '$user_name'");
									$rows = mysqli_num_rows($check_request);
									if ($rows > 0) {
										$get = mysqli_query($con, "SELECT * FROM `notifications` n join `signup` s on s.user_id = n.user_id join `friend_requests` f on f.request_id = n.friend_request_id WHERE n.sender_id = '$user_id' ORDER BY `notification_id` DESC LIMIT 5");
										while ($all = mysqli_fetch_assoc($get)) {
											$dateObject = new DateTime($all['send_date']);
											$formattedDate = $dateObject->format('F d, Y');

									?>
											<div class="list-group" id="alerts" role="tablist">
												<a href="#" class="filterNotifications all latest notification" data-toggle="list">
													<img class="avatar-md" src="<?php echo $all['user_image'] ?>" data-toggle="tooltip" data-placement="top" title="<?php echo ucfirst($all['user_name']); ?>" alt="avatar">
													<!-- <div class="status">
														<i class="material-icons online">fiber_manual_record</i>
													</div> -->
													<?php

													if ($all['request_status'] == "declined" && $all['request_time'] == "false") {


													?>
														<div class="data">
															<p>You declined <?php echo ucfirst($all['send_by']); ?>'s request. </p>
															<span><?php echo $formattedDate; ?></span>
														</div>
													<?php
													} elseif ($all['request_status'] == "accepted" && $all['request_time'] == "true") {

													?>

														<div class="data">
															<p>You have accepted <?php echo ucfirst($all['send_by']); ?>'s request. </p>
															<span><?php echo $formattedDate; ?></span>
														</div>

													<?php
													} elseif ($all['request_status'] == "unfriended" && $all['request_time'] == "false") {

													?>

														<div class="data">
															<p>You have unfriended <?php echo ucfirst($all['send_by']); ?>. </p>
															<span><?php echo $formattedDate; ?></span>
														</div>

													<?php
													} else {
													?>
														<div class="data">
															<p> <?php echo ucfirst($all['user_name']); ?> send you a friend request. <button class="btn btn-sm rounded-pill text-light bg-success" id="accept" data-user-id="<?php echo $all['sender_id']; ?>" data-sender-id="<?php echo $all['user_id']; ?>">Accept</button><button class="btn btn-sm rounded-pill text-light bg-danger" id="decline" data-user-id="<?php echo $user_id; ?>" data-sender-id="<?php echo $all['user_id']; ?>">Decline</button></p>
															<span><?php echo $formattedDate; ?></span>
														</div>
													<?php } ?>
												</a>
											</div>
											<?php
										}
									}
									$check_send_to = mysqli_query($con, "SELECT * FROM `friend_requests` WHERE `send_by` = '$user_name'");
									$now_rows = mysqli_num_rows($check_send_to);
									if ($now_rows > 0) {
										$sql = mysqli_query($con, "SELECT * FROM `notifications` n join `signup` s on s.user_id = n.sender_id join `friend_requests` f on f.request_id = n.friend_request_id WHERE n.user_id = '$user_id'");
										$num_rows = mysqli_num_rows($sql);
										if ($num_rows > 0) {
											while ($row = mysqli_fetch_assoc($sql)) {
												$dateObject = new DateTime($row['send_date']);
												$formattedDate = $dateObject->format('F d, Y');

											?>
												<div class="list-group" id="alerts" role="tablist">
													<a href="#" class="filterNotifications all latest notification" data-toggle="list">
														<img class="avatar-md" src="<?php echo $row['user_image'] ?>" data-toggle="tooltip" data-placement="top" title="<?php echo ucfirst($row['user_name']); ?>" alt="avatar">
														<!-- <div class="status">
															<i class="material-icons online">fiber_manual_record</i>
														</div> -->
														<?php
														if ($row['request_status'] == "declined" && $row['request_time'] == "false") {


														?>
															<div class="data">
																<p><?php echo ucfirst($row['send_to']); ?> has declined your request. </p>
																<span><?php echo $formattedDate; ?></span>
															</div>


														<?php
														} elseif ($row['request_status'] == "accepted" && $row['request_time'] == "true") {

														?>

															<div class="data">
																<p><?php echo ucfirst($row['send_to']); ?> has accepted your request. </p>
																<span><?php echo $formattedDate; ?></span>
															</div>

														<?php
														} elseif ($row['request_status'] == "unfriended" && $row['request_time'] == "false") {

														?>

															<div class="data">
																<p><?php echo ucfirst($row['send_to']); ?> has unfriended you. </p>
																<span><?php echo $formattedDate; ?></span>
															</div>

														<?php
														} else {


														?>
															<div class="data">
																<p>request send to <?php echo ucfirst($row['send_to']); ?> is still pending. </p>
																<span><?php echo $formattedDate; ?></span>
															</div>
														<?php } ?>
													</a>
												</div>
										<?php
											}
										}
									} elseif ($rows == 0) {
										?>
										<div class="data">
											<h5>No Notifications to show</h5>
										</div>
									<?php
									}

									?>
								</div>
							</div>
							<!-- End of Notifications -->
							<!-- Start of Settings -->
							<div class="tab-pane fade" id="settings">
								<?php
								$id = $_SESSION['id'];
								$profile = mysqli_query($con, "SELECT * FROM `signup` where `user_id` = '$id'");
								$fetch = mysqli_fetch_assoc($profile);
								?>
								<div class="settings">
									<div class="profile">
										<img class="avatar-xl" src="<?php echo $fetch['user_image']; ?>" alt="avatar">
										<h1><a href="#"><?php echo ucfirst($fetch['user_name']); ?></a></h1>
										<span><?php echo $fetch['user_location']; ?></span>
										<div class="stats">
											<div class="item">
												<?php
												$name = $fetch['user_name'];
												$check_friend = mysqli_query($con, "SELECT * FROM `friend_requests` where (send_by = '$name' or send_to = '$name') AND request_status = 'accepted'");
												$firend_count = mysqli_num_rows($check_friend);
												if ($firend_count > 0) {

												?>
													<h2><?php echo $firend_count; ?></h2>
													<h3>friends</h3>
												<?php
												} else {
												?>
													<h3>No Friends</h3>
												<?php
												}
												?>

											</div>
											<div class="item">
												<?php
												$name = $fetch['user_name'];
												$check_msg = mysqli_query($con, "SELECT * FROM `messages` where sender_username = '$name' or receiver_username = '$name'");
												$msg_count = mysqli_num_rows($check_msg);
												if ($msg_count > 0) {

												?>
													<h2><?php echo $msg_count; ?></h2>
													<h3>Messages</h3>
												<?php
												} else {
												?>
													<h3>No Messages</h3>
												<?php
												}
												?>

											</div>
										</div>
									</div>
									<div class="categories" id="accordionSettings">
										<h1>Update Your profile details</h1>
										<!-- Start of My Account -->
										<div class="category">

											<div>
												<div class="content">
													<form method="post" id="update_data" enctype="multipart/form-data">
														<div class="upload">
															<div class="data">
																<img class="avatar-xl" src="<?php echo $fetch['user_image']; ?>" alt="image">
																<label>
																	<form method="post" enctype="multipart/form-data">
																		<input type="file" id="up_img" data-user-img="<?php echo $fetch['user_image']; ?>">
																		<span class="btn button">Update image</span>
																	</form>
																</label>
															</div>
														</div>
														<div class="field">
															<label for="lastName">Name <span>*</span></label>
															<input type="text" class="form-control" data-user-name="<?php echo $fetch['user_name']; ?>" id="name" placeholder="name" value="<?php echo $fetch['user_name']; ?>" required>
														</div>
														<div class="field">
															<label for="email">Email <span>*</span></label>
															<input type="email" class="form-control" id="email" placeholder="Enter your email address" value="<?php echo $fetch['user_email']; ?>" data-user-email="<?php echo $fetch['user_email']; ?>" required>
														</div>
														<div class="field">
															<label for="password">Password</label>
															<input type="password" class="form-control" id="password" placeholder="Enter a new password">
														</div>
														<div class="field">
															<label for="location">Location</label>
															<input type="text" class="form-control" id="location" placeholder="Enter your location" value="<?php echo $fetch['user_location']; ?>" data-user-loc="<?php echo $fetch['user_location']; ?>" disabled>
														</div>
														<button type="submit" id="update" class="btn button w-100">Update</button>
														<button type="submit" class="btn bg-danger button w-100 mt-2" id="delete-account" data-loggined="<?php echo $_SESSION['name']; ?>">Delete Account</button>
													</form>
												</div>
											</div>
										</div>
										<!-- End of My Account -->
										<!-- Start of Chat History -->
										<!-- Start of Logout -->
										<div class="category">
											<a href="logout.php" class="title collapsed">
												<i class="material-icons md-30 online">power_settings_new</i>
												<div class="data">
													<h5>Power Off</h5>
													<p>Log out of your account</p>
												</div>
												<i class="material-icons">keyboard_arrow_right</i>
											</a>
										</div>
										<!-- End of Logout -->
									</div>
								</div>
							</div>

							<!-- End of Settings -->
						</div>
					</div>
				</div>
			</div>
			<!-- End of Sidebar -->