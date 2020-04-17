<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	foreach ($_COOKIE as $cookie_name => $cookie_value) {
		unset($_COOKIE[$cookie_name]);
		setcookie($cookie_name, '', time() - 4200, '/');
	}
	header("location: login.php");
}

if (isset($_GET['error'])) {
?>
	<script>
		alert("<?php echo htmlspecialchars($_GET['error'], ENT_QUOTES); ?>")
	</script>
<?php
}

$db = mysqli_connect('localhost', 'root', '"K*d0e=A', 'wakoky');
if (!$db) {
	die("Connection failed: " . mysqli_connect_error());
}
include('serverPlaylist.php');
if (isset($_COOKIE['playing'])) {
	if ($_COOKIE['playing'] == '1' && $_COOKIE['loaded'] == '0')
		reload_playlist();
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Wakoky</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="stylesheet" type="text/css" href="style/session.css">
	<link rel="icon" type="image/ico" href="assets/logo_zoom.png" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/tomorrow.min.css">
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

	<script type="text/javascript">
		window._mNHandle = window._mNHandle || {};
		window._mNHandle.queue = window._mNHandle.queue || [];
		medianet_versionId = "3121199";
	</script>
	<script src="https://contextual.media.net/dmedianet.js?cid=8CU9AE433" async="async"></script>
</head>

<body>
	<?php if (isset($_SESSION['success'])) : ?>
		<div id="video-placeholder"></div>
		<?php include('session_template.php'); ?>
		<div id="818251611">
			<script type="text/javascript">
				try {
					window._mNHandle.queue.push(function() {
						window._mNDetails.loadTag("818251611", "160x600", "818251611");
					});
				} catch (error) {}
			</script>
		</div>
	<?php endif ?>
	</div>
</body>

</html>