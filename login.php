<?php include('server') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Wakoky Sign in</title>
	<link rel="stylesheet" type="text/css" href="style/login.css">
	<link rel="icon" type="image/ico" href="assets/logo_zoom.png" />
	<script type="text/javascript">
		window._mNHandle = window._mNHandle || {};
		window._mNHandle.queue = window._mNHandle.queue || [];
		medianet_versionId = "3121199";
	</script>
	<script src="https://contextual.media.net/dmedianet.js?cid=8CU9AE433" async="async"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="popupHelp.js"></script>
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
				<form id="login" method="post" action="login">
					<?php include('errors.php'); ?>
					<a class="trigger_popup_fricc">What is Wakoky ?</a>
					<label for="username">User Name</label>
					<input required name="username" type="text" autocapitalize="off" autocorrect="off" />

					<label for="password">Password</label>
					<input class="password" required name="password" type="password" />
					<button type="submit" name="login_user">Sign In</button>
					<div class="sign_up"><a href="register">You don't have an account ? Sign Up Here</a></div>
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
	</div>
</body>

</html>