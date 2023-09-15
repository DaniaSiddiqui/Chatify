</div> <!-- Layout -->
</main>
<!-- Bootstrap/Swipe core JavaScript
		================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script type='text/javascript' src='js/jquery.js'></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="dist/js/vendor/popper.min.js"></script>
<script src="dist/js/swipe.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<script>
	window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')
</script>
<script>
	function scrollToBottom(el) {
		el.scrollTop = el.scrollHeight;
	}
	scrollToBottom(document.getElementById('content'));
</script>
<Script>
	$(document).ready(function() {

		$("#user").on("keyup", function() {
			var username = $(this).val().trim();
			if (username != "") {
				$.ajax({
					url: "showuser.php",
					type: "POST",
					data: {
						user: username
					},
					success: function(data) {
						$("#load-data").html(data);
					}
				});
			} else {
				$("#load-data").html('');
			}

		})

		$("#submit-form").on("submit", function(e) {
			e.preventDefault();
			var user = $("#user").val();
			$.ajax({
				url: "adduser.php",
				type: "POST",
				data: {
					username: user
				},
				success: function(data) {
					if (data == "Successfully Send Friend Request") {

						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Friend request send successfull',
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});

					} else {
						var msg = data;
						Swal.fire({
							position: 'top-end',
							icon: 'warning',
							title: msg,
							showConfirmButton: false,
							timer: 3000
						})
					}
				}
			})
		})

		$(document).on('click', '#addFriend', function(e) {
			e.preventDefault();
			var user = $(this).data('friend-id');
			$.ajax({
				url: "adduser.php",
				type: "POST",
				data: {
					username: user
				},
				success: function(data) {
					if (data == "Successfully Send Friend Request") {

						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Friend request send successfull',
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});

					} else {
						var msg = data;
						Swal.fire({
							position: 'top-end',
							icon: 'warning',
							title: msg,
							showConfirmButton: false,
							timer: 3000
						})
					}
				}
			})
		})

		$("#participant").on("keyup", function(e) {
			e.preventDefault();
			var participant = $("#participant").val();
			var message = $("#message").val();
			var user = $("#login_user").val();
			if (participant != "") {
				$.ajax({
					url: "searchuser.php",
					type: "POST",
					data: {
						friend: participant,
						login_user: user
					},
					success: function(data) {
						$("#lodd-data").html(data)
					}
				})
			} else {
				$("#lodd-data").html('');
			}

		})

		//send message with database insertion
		$("#sub-form").on("submit", function(e) {
			e.preventDefault();
			var participant = $("#participant").val();
			var message = $("#message").val();
			var user = $("#login_user").val();

			$.ajax({
				url: "sendmessage.php",
				type: "POST",
				data: {
					friend: participant,
					login_user: user,
					msg: message
				},
				success: function(data) {
					if (data === '1') {
						var conn = new WebSocket('ws://localhost:8080');
						conn.onopen = function(e) {
							console.log("Connection established!");
						};

						conn.onmessage = function(e) {
							var getdata = JSON.parse(e.data);
						};

						var content = {
							msg: message,
							send_by: user,
							send_to: participant
						};

						conn.onopen = function() {
							conn.send(JSON.stringify(content));
							Swal.fire({
								position: 'top-end',
								icon: 'success',
								title: 'Message sent successfully',
								showConfirmButton: false,
								timer: 3000
							}).then(function() {
								location.reload();
							});
						};

					} else {
						Swal.fire({
							position: 'top-end',
							icon: 'danger',
							title: data,
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});
					}


				}



			})

		})


		//send image with database insertion
		$("#input_file").on("change", function(e) {
			e.preventDefault();
			var friend = $("#friend").val();
			var login = $("#login").val();
			var image_file = this.files[0];
			var form_data = new FormData();
			form_data.append("image", image_file);
			form_data.append("friend", friend); // Append hidden data
			form_data.append("login", login); // Append hidden data

			$.ajax({
				url: 'send_img.php',
				type: 'POST',
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
					if (response == 1) {
						var conn = new WebSocket('ws://localhost:8080');
						conn.onopen = function(e) {
							console.log("Connection established!");
						};

						conn.onmessage = function(e) {
							var getdata = JSON.parse(e.data);
						};

						var content = {
							msg: image_file,
							send_by: login,
							send_to: friend
						};

						conn.onopen = function() {
							conn.send(JSON.stringify(content));
							location.reload();
						};
					} else {
						Swal.fire({
							position: 'top-end',
							icon: 'danger',
							title: response,
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});
					}

				}
			});

		})

		//search people
		$("#people").on("keyup", function() {
			var search_word = $(this).val().trim();
			if (search_word != "") {
				$.ajax({
					url: "live_search.php",
					type: "POST",
					data: {
						search: search_word
					},
					success: function(data) {
						$("#contactsContainer").html(data);
						$("#contacts").hide()
					}
				});
			} else {
				$("#contactsContainer").html("");
				$("#contacts").show();
			}

		})

		//search messages
		$("#conversations").on("keyup", function() {
			var search_word = $(this).val().trim();
			if (search_word != "") {
				$.ajax({
					url: "search_messages.php",
					type: "POST",
					data: {
						search_message: search_word
					},
					success: function(data) {
						$("#messagesContainer").html(data);
						$("#chats").hide()
					}
				});
			} else {
				$("#messagesContainer").html("");
				$("#chats").show();
			}

		})

		//updating the data 
		$(document).on("click", "#update", function(e) {
			e.preventDefault();

			var name = $("#name").val();
			var org_name = $("#name").data('user-name');
			var email = $("#email").val();
			var org_email = $("#email").data('user-email');
			var password = $("#password").val();

			var selectedImage = $("#up_img").prop("files")[0];
			var formData = new FormData();
			formData.append('upimage', selectedImage);

			if ((name === org_name && email === org_email && password === "") && !selectedImage) {
				Swal.fire({
					position: 'top-end',
					icon: 'warning',
					title: "Data Unchanged",
					showConfirmButton: false,
					timer: 3000
				});
			} else {
				var formdata = new FormData();
				formdata.append("upname", name);
				formdata.append("upemail", email);
				formdata.append("uppass", password);
				formdata.append("image", selectedImage);

				$.ajax({
					type: "post",
					url: "update_data.php",
					data: formdata,
					contentType: false,
					processData: false,
					success: function(response) {
						if (response === "Image updated successfully!") {
							Swal.fire({
								position: 'top-end',
								icon: 'success',
								title: response,
								showConfirmButton: false,
								timer: 3000
							}).then(function() {
								location.reload();
							});
						} else if (response === "Data updated successfully!") {
							Swal.fire({
								position: 'top-end',
								icon: 'success',
								title: response,
								showConfirmButton: false,
								timer: 3000
							}).then(function() {
								location.reload();
							});
						} else {
							Swal.fire({
								position: 'top-end',
								icon: 'error',
								title: response,
								showConfirmButton: false,
								timer: 3000
							}).then(function() {
								location.reload();
							});
						}
					}
				});
			}
		});


		$(document).on('click', '#unfriend', function() {
			var loginuser = $(this).data('login-user');
			var friend = $(this).data('friend-id');
			$.unfriend(loginuser, friend);
		});

		$.unfriend = function(login, friend) {

			var login_user = login;
			var unfriend_request = friend;
			$.ajax({
				url: "unfrienduser.php",
				type: "POST",
				data: {
					unfriend_by: login_user,
					unfriend_to: unfriend_request
				},
				success: function(data) {
					if (data == 1) {
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'You Unfriended ' + unfriend_request,
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});
					} else {
						Swal.fire({
							position: 'top-end',
							icon: 'warning',
							title: data,
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});
					}
				}
			})

		}

		$(document).on('click', '#accept', function() {
			var loginuser = $(this).data('user-id');
			var friend = $(this).data('sender-id');
			$.requesthandle('accepted', loginuser, friend);
		});

		$(document).on('click', '#decline', function() {
			var loginuser = $(this).data('user-id');
			var friend = $(this).data('sender-id');
			$.requesthandle('decline', loginuser, friend);
		});

		$.requesthandle = function(status, login, friend) {

			var status = status;
			var login_user = login;
			var friend_request = friend;
			$.ajax({
				url: "handlerequest.php",
				type: "POST",
				data: {
					request_status: status,
					sended_to: login_user,
					sended_by: friend_request
				},
				success: function(data) {
					if (data == 1) {
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Congratulations you have a new friend',
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});
					} else {
						Swal.fire({
							position: 'top-end',
							icon: 'warning',
							title: data,
							showConfirmButton: false,
							timer: 3000
						}).then(function() {
							location.reload();
						});
					}
				}
			})

		}

		//send message
		function playNotificationSound() {
			var notificationSound = document.getElementById('notificationSound');
			notificationSound.play();
		}

		function sendmessage() {
			var participant = $("#partner_name").val();
			var message = $("#msg").val();
			var user = $("#logind_user").val();
			if (message != "") {
				$.ajax({
					url: "sendmessage.php",
					type: "POST",
					data: {
						friend: participant,
						login_user: user,
						msg: message
					},
					success: function(data) {
						if (data === '1') {
							var conn = new WebSocket('ws://localhost:8080');
							conn.onopen = function(e) {
								console.log("Connection established!");

								var content = {
									msg: message,
									send_by: user,
									send_to: participant
								};

								conn.send(JSON.stringify(content));
								playNotificationSound()
								location.reload();
							};

							conn.onmessage = function(e) {
								var getdata = JSON.parse(e.data);
							};
						} else {
							Swal.fire({
								position: 'top-end',
								icon: 'danger',
								title: data,
								showConfirmButton: false,
								timer: 3000
							}).then(function() {
								location.reload();
							});
						}
					}
				});
			}

		}


		$("#subm-form").on("submit", function(e) {
			e.preventDefault();
			sendmessage();
		});

		//sending message on enter key
		$("#msg").on("keydown", function(event) {
			if (event.keyCode === 13 && !event.shiftKey) {
				event.preventDefault();
				sendmessage();
			}
		});


		//updating online offfline status
		function update_status(){
             $.ajax({
				url : 'update_activity.php',
				success : function(){

				}
			 })
		}
        
        setInterval(function(){
           update_status()
		} ,3000)

        function get_user_status(){
			$.ajax({
				url : "get_user_status.php",
				success : function(result){
                    $('.status').html(result)
				}
			})
		}
		setInterval(function(){
			get_user_status()
		} ,7000)

		//deleting account
		$("#delete-account").on("click", function(e) {
			e.preventDefault();

			const me = $(this).data("loggined-user");

			Swal.fire({
				title: 'Are you sure you want to delete your account?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: "deluser.php",
						type: "POST",
						data: {
							loggined: me
						},
						success: function(data) {
							if (data == 1) {
								Swal.fire({
									position: 'top-end',
									icon: 'success',
									title: 'Account Deleted',
									showConfirmButton: false,
									timer: 3000
								}).then(function() {
									location.href = "signup.php";
								});
							}
						}
					});
				}
			});
		});


	})
</Script>
</body>

</html>