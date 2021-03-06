<?php include('server/UserServer.php') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Sign in</title>
	<link rel="stylesheet" type="text/css" href="style/signIn.css">
	<link rel="icon" type="image/ico" href="assets/logo_zoom.png" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="scripts/popupHelp.js"></script>
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
	<!-- Pinterest -->
	<meta name="p:domain_verify" content="c48adff9f6d32ff20cbfe87194d22afa" />
</head>

<body>
	<div class="hover_bkgr_fricc">
		<span class="helper"></span>
		<div>
			<div class="popupCloseButton">&times;</div>
			<p>Wakoky is a free platform where you can create your playlists using YouTube's links.</p>
		</div>
	</div>
	<div class="content">
		<div class="login_form">
			<setion class="login-wrapper">
				<div class="logo">
					<img src="assets/logo.png" alt=""></a>
				</div>
				<form id="login" method="post" action="signIn.php">
					<?php include('errors.php'); ?>
					<a class="trigger_popup_fricc">What is Wakoky ?</a>
					<label for="username">User Name</label>
					<input required name="username" type="text" autocapitalize="off" autocorrect="off" />

					<label for="password">Password</label>
					<input class="password" required name="password" type="password" />
					<button type="submit" name="login_user">Sign In</button>
					<div class="sign_up">
						<a href="signUp.php">You don't have an account ? Sign Up Here</a>
					</div>
				</form>
				</section>
		</div>
	</div>
</body>

</html>