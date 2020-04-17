<?php include('server.php') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Wakoky Sign in</title>
	<link rel="stylesheet" type="text/css" href="style/login.css">
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
				<form id="login" method="post" action="login.php">
					<?php include('errors.php'); ?>
					<a class="trigger_popup_fricc">What is Wakoky ?</a>
					<label for="username">User Name</label>
					<input required name="username" type="text" autocapitalize="off" autocorrect="off" />

					<label for="password">Password</label>
					<input class="password" required name="password" type="password" />
					<button type="submit" name="login_user">Sign In</button>
					<div class="sign_up"><a href="register.php">You don't have an account ? Sign Up Here</a></div>
				</form>
				</section>
		</div>
	</div>
	<div class="alignleft">
		<script type="text/javascript">
			amzn_assoc_ad_type = "banner";
			amzn_assoc_marketplace = "amazon";
			amzn_assoc_region = "US";
			amzn_assoc_placement = "assoc_banner_placement_AssociatesUS";
			amzn_assoc_banner_type = "ez";
			amzn_assoc_p = "13";
			amzn_assoc_width = "468";
			amzn_assoc_height = "60";
			amzn_assoc_tracking_id = "wakoky-20";
			amzn_assoc_linkid = "6b054e28eca7496fdbad8a477377acb5";
		</script>
		<script src="//z-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1"></script>
	</div>
</body>

</html>