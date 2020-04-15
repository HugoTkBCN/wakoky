<?php include('server.php') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Wakoky Sign In</title>
	<link rel="stylesheet" type="text/css" href="style/register.css">
	<link rel="icon" type="image/ico" href="assets/logo_zoom.png" />
	<script data-ad-client="ca-pub-1653403322985348" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body>
	<div class="register_form">

		<setion class="register-wrapper">
			<div class="logo">
				<img src="assets/logo.png" alt=""></a>
			</div>

			<form id="register" method="post" action="register.php">
				<?php include('errors.php'); ?>
				<label for="username">User Name</label>
				<input required name="username" type="text" autocapitalize="off" autocorrect="off" />

				<label for="email">Email</label>
				<input required name="email" type="text" autocapitalize="off" autocorrect="off" />

				<label for="password">Password</label>
				<input class="password" required name="password_1" type="password" />
				<label for="password">Confirm Password</label>
				<input class="password" required name="password_2" type="password" />
				<div>
				<button type="submit" name="reg_user">Sign Up</button>
				<div class="sign_in"><a href="login.php">Already a member ?  Sign In Here</a></div>
			</form>
			</section>
	</div>
</body>

</html>