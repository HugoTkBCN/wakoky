<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	foreach ($_COOKIE as $cookie_name => $cookie_value) {
		unset($_COOKIE[$cookie_name]);
		setcookie($cookie_name, '', time() - 4200, '/');
	}
	header("location: login");
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
</head>

<body>
	<?php if (isset($_SESSION['success'])) : ?>
		<div id="video-placeholder"></div>
		<?php include('session_template.php'); ?>
	<?php endif ?>
	</div>
</body>

</html>