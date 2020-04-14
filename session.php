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
<div>

	<?php if (isset($_SESSION['username'])) : ?>
		<div class="playlists">
			<form class="add_playlist" method="post" action="session.php">
				<div class="add_item">
					<input type="text" name="name">
				</div>
				<div class="add_item">
					<button type="submit" name="add_playlist">create playlist</button>
				</div>
			</form>
			<?php include('printPlaylists.php'); ?>
		</div>
	<?php endif ?>
</div>