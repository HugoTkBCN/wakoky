<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>
<script type="text/javascript">var username = "<?= $_SESSION['username'] ?>";</script>
<script type="text/javascript" src="serverPlaylist.js"></script>
<?php include('serverPlaylist.php') ?>
<!DOCTYPE html>
<html>

<head>
	<title>Session</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" type="image/ico" href="logo_zoom.png" />

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/tomorrow.min.css">
</head>

<body>
	<div>

		<?php if (isset($_SESSION['username'])) : ?>
			<div class="playlists">
				<form class="add_playlist" name="formAddPlaylist" action="#" method="post" onsubmit="createPlaylist();return false">
					<div class="add_item">
						<input type="text" name="fname" />
					</div>
					<div class="add_item">
						<input type="submit" name="Submit" />
					</div>
				</form>
				<?php include('printPlaylists.php'); ?>
			</div>
		<?php endif ?>
	</div>
</body>

</html>