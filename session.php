<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>
<?php include('serverPlaylist.php') ?>
<div>

	<?php if (isset($_SESSION['username'])) : ?>
		<div class="playlists">
			<?php include('printPlaylists.php'); ?>
		</div>
	<?php endif ?>
</div>