<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Sign Up – Chatify</title>
	<meta name="description" content="#">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap core CSS -->
	<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
	<!-- Swipe core CSS -->
	<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
	<!-- Favicon -->
	<link href="dist/img/favicon.png" type="image/png" rel="icon">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="start">
	<main>
		<div class="layout">
			<!-- Start of Sign Up -->
			<div class="main order-md-2">
				<div class="start">
					<div class="container">
						<div class="col-md-12">
							<div class="content">
								<h1>Create Chatify Account</h1>
								<?php
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json");
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$result = curl_exec($ch);
								$result = json_decode($result);
								$location = "";
								if ($result->status == 'success') {
									$location .=  $result->city  . " , " . $result->country;
								}
								?>
								<form class="signup" id="submit-form" method="post" enctype="multipart/form-data">
									<div class="form-parent">
										<div class="form-group">
											<input type="text" id="inputName" class="form-control" placeholder="Username" name="name" autocomplete="off" required>
											<button class="btn icon"><i class="material-icons">person_outline</i></button>
										</div>
										<div class="form-group">
											<input type="email" id="inputEmail" class="form-control" placeholder="Email Address" autocomplete="off" name="email" required>
											<button class="btn icon"><i class="material-icons">mail_outline</i></button>
										</div>
									</div>
									<div class="form-group">
										<input type="password" id="inputPassword" class="form-control" placeholder="Password" autocomplete="off" name="pass" required>
										<button class="btn icon"><i class="material-icons">lock_outline</i></button>
									</div>
									<div class="form-parent">
										<div class="form-group">
											<input type="text" id="inputLoc" class="form-control" value="<?php echo $location;?>" disabled>

										</div>
										<div class="form-group">
											<input type="file" id="inputImg" class="form-control" name="image">
										</div>
									</div>
									<button type="submit" class="btn button" id="submit">Sign Up</button>
									<div class="callout">
										<span>Already a member? <a href="sign-in.html">Sign In</a></span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Sign Up -->
			<!-- Start of Sidebar -->
			<div class="aside order-md-1">
				<div class="container">
					<div class="col-md-12">
						<div class="preference">
							<h2>Welcome Back!</h2>
							<p>To keep connected with your friends please login with your personal info.</p>
							<a href="signin.php" class="btn button">Sign In</a>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Sidebar -->
		</div> <!-- Layout -->
	</main>
	<!-- Bootstrap core JavaScript
		================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script>
		window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')
	</script>
	<script src="dist/js/vendor/popper.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<script>
		$(document).ready(function() {
			$("#submit-form").on("submit", function(e) {
				e.preventDefault();
				let name = $("#inputName").val();
				let email = $("#inputEmail").val();
				let password = $("#inputPassword").val();
				let location = $("#inputLoc").val();
				let image = $("#inputImg")[0].files[0]; // Get the selected image file
                  
				var formdata = new FormData();
				formdata.append("name", name);
				formdata.append("email", email);
				formdata.append("password", password);
				formdata.append("location", location);
				formdata.append("image", image); // Append the image file to the form data

				$.ajax({
					url: "register.php",
					type: "POST",
					data: formdata,
					contentType: false,
					processData: false,
					success: function(data) {
						if (data == "You Registered Successfully") {
							window.location.href = 'signin.php';
						} else {
							alert(data);
						}
					},
				});
			});
		})
	</script>
</body>


</html>