<?php include('server/UserServer') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="style/register.css">
	<link rel="icon" type="image/ico" href="assets/logo_zoom.png" />
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163901596-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-163901596-1');
	</script>
</head>

<body>
	<div class="register_form">

		<setion class="register-wrapper">
			<div class="logo">
				<img src="assets/logo.png" alt=""></a>
			</div>

			<form id="register" method="post" action="register">
				<?php include('errors'); ?>
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
					<div class="sign_in"><a href="login">Already a member ? Sign In Here</a></div>
			</form>
			</section>
	</div>
</body>

</html>