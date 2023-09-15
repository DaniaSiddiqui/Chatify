<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Sign In – Chatify</title>
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
	
</head>

<body class="start">
	<main>
		<div class="layout">
			<!-- Start of Sign In -->
			<div class="main order-md-1">
				<div class="start">
					<div class="container">
			
						<div class="col-md-12">
							<div class="content">
								<h1>Sign in to Chatify</h1>
								<form id="submit-form" method="post">
									<div class="form-group">
										<input type="email" id="inputEmail" class="form-control" value="<?php if(isset($_COOKIE['remember_email'])){echo $_COOKIE['remember_email'];}?>" placeholder="Email Address" required>
										<button class="btn icon"><i class="material-icons">mail_outline</i></button>
									</div>
									<div class="form-group">
										<input type="password" id="inputPassword" class="form-control" placeholder="Password" value = "<?php if(isset($_COOKIE['password'])){$decrypt = base64_decode($_COOKIE['password']); echo $decrypt;}?>" required>
										<button class="btn icon"><i class="material-icons">lock_outline</i></button>
									</div>
									<div class="form-group float-left mt-2">
									<input type="checkbox" name="rememberme" id="check" <?php if(isset($_COOKIE['remember_email'])){ ?> checked <?php }?>>
									<label for="check" style="margin-left: 4px; color: #a39d9d;">
										Remember Me
									</label>
									</div>
									<button type="submit" class="btn button" name="">Sign In</button>
									<div class="callout">
										<span>Don't have account? <a href="sign-up.html">Create Account</a></span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Sign In -->
			<!-- Start of Sidebar -->
			<div class="aside order-md-2">
				<div class="container">
					<div class="col-md-12">
						<div class="preference">
							<h2>Hello, Friend!</h2>
							<p>Enter your personal details and start your journey with Chatify today.</p>
							<a href="signup.php" class="btn button">Sign Up</a>
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
	<script type='text/javascript' src='js/jquery.js'></script>
	<script src="dist/js/vendor/popper.min.js"></script>
	<script src="dist/js/swipe.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')
	</script>

	<script>
		$(document).ready(function() {
    $("#submit-form").on("submit", function(e) {
        e.preventDefault();
        var email = $("#inputEmail").val();
        var pass = $("#inputPassword").val();
        var rememberMe = $("#check").prop("checked");
		var data = {
            email_id: email,
            password: pass
        };

        if (rememberMe) {
            data.remember_me = rememberMe;
        }
        $.ajax({
            url: "login.php",
            type: "POST",
            data: data,
            success: function(data) {
                if (data == "Successfully Login") {
                    window.location.href = "index.php";
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });
    });
    
});

	</script>
</body>

</html>