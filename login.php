<?php include('server.php') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Wakoky Sign in</title>
	<link rel="stylesheet" type="text/css" href="style/login.css">
	<link rel="icon" type="image/ico" href="assets/logo_zoom.png" />
</head>

<body>
	<div></div>
	<div class="login_form">

		<setion class="login-wrapper">
			<div class="logo">
				<img src="assets/logo.png" alt=""></a>
			</div>

			<form id="login" method="post" action="login.php">
				<?php include('errors.php'); ?>
				<label for="username">User Name</label>
				<input required name="username" type="text" autocapitalize="off" autocorrect="off" />

				<label for="password">Password</label>
				<input class="password" required name="password" type="password" />
				<button type="submit" name="login_user">Sign In</button>
				<div class="sign_up"><a href="register.php">You don't have an account ? Sign Up Here</a></div>
			</form>
			</section>
	</div>
	<div id="818251611">
		<script type="text/javascript">
			try {
				window._mNHandle.queue.push(function() {
					window._mNDetails.loadTag("818251611", "160x600", "818251611");
				});
			} catch (error) {}
		</script>
	</div>
</body>

</html>