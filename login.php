<?php include('server.php') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Wakoky Sign in</title>
	<link rel="stylesheet" type="text/css" href="login.css">
	<link rel="icon" type="image/ico" href="logo_zoom.png" />
</head>

<body>
	<div class="login_form">

		<setion class="login-wrapper">
			<div class="logo">
				<img src="logo.png" alt=""></a>
			</div>

			<form id="login" method="post" action="login.php">
				<?php include('errors.php'); ?>
				<label for="username">User Name</label>
				<input required name="username" type="text" autocapitalize="off" autocorrect="off" />

				<label for="password">Password</label>
				<input class="password" required name="password" type="password" />
				<button type="submit" name="login_user">Sign In</button>
				<div class="sign_up"><a href="register.php">You don't have an account ?  Sign Up Here</a></div>
			</form>
			</section>
	</div>
</body>

</html>