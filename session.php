<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

$errors = array();

// connect to database
$db = mysqli_connect('localhost', 'root', '"K*d0e=A', 'wakoky');

if (!$db) {
	die("Connection failed: " . mysqli_connect_error());
}
?>
<?php include('serverPlaylist.php') ?>
<?php include('errors.php'); ?>

<!DOCTYPE html>
<html>

<head>
	<title>Session</title>
	<link rel="stylesheet" type="text/css" href="style.css">

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/tomorrow.min.css">
</head>

<body>
	<div>

		<?php if (isset($_SESSION['username'])) : ?>
			<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
			<p> <a href="index.php?logout='1'">logout</a> </p>

			<form class="add_playlist" method="post" action="session.php">
				<div class="add_item">
					<label>Name</label>
					<input type="text" name="name">
				</div>
				<div class="add_item">
					<button type="submit" name="add_playlist">create playlist</button>
				</div>
			</form>
			<div class="playlists">
				<?php include('printPlaylists.php'); ?>
			</div>
			<div class=player>
				<div id="video-placeholder"></div>
				<div id="controls">
					<ul>
						<li>
							<i id="play" class="material-icons">play_arrow</i>
							<i id="pause" class="material-icons">pause</i>
							<div id="time"><span id="current-time">0:00</span> / <span id="duration">0:00</span></div>
							<input type="range" id="progress-bar" value="0">
							<i id="mute-toggle" class="material-icons">volume_up</i>
							<input id="volume-input" type="number" max="100" min="0">
							<i id="prev" class="material-icons">fast_rewind</i>
							<i id="next" class="material-icons">fast_forward</i>
						</li>
					</ul>
				</div>
			</div>
			<script src="https://www.youtube.com/iframe_api"></script>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
			<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
			<script type="text/javascript">
				var myPLaylist = <?php echo '["' . implode('", "', $_SESSION['actual_playlist']) . '"]' ?>;
			</script>
			<script type="text/javascript" src="script.js"></script>
		<?php endif ?>
	</div>

</body>

</html>