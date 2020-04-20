<div class="info_playlists">
    <form class="add_playlist" method="post">
        <strong>
            <p>Add New Playlist</p>
        </strong>
        <div class="add_item">
            <input class="inputPlaylistName" type="text" name="name">
            <input type="hidden" name="add_playlist"></input>
            <input class="addPlaylist" type="image" src="assets/add.png" width="30" height="30"></input>
        </div>
    </form>
    <div class="container_playlist_list">
        <?php include('printListPlaylists'); ?>
    </div>
</div>
<?php
if (isset($_COOKIE['playlist_id']))
    include("printPlaylist");
?>