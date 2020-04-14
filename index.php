<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: login.php");
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Wakoky</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="session.css">
	<link rel="icon" type="image/ico" href="logo_zoom.png" />
</head>

<body>
	<?php if (isset($_SESSION['success'])) : ?>
		<div id="video-placeholder"></div>
		<?php include('session_template.php'); ?>
	<?php endif ?>
	</div>
</body>

</html>