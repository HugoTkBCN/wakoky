<?php
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '"K*d0e=A', 'wakoky');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div class="info_playlists">
    <form class="add_playlist" method="post" action="serverPlaylist.php">
        <strong>
            <p>Add New Playlist</p>
        </strong>
        <div class="add_item">
            <input class="inputPlaylistName" type="text" name="name">
            <input type="hidden" name="add_playlist"></input>
            <input class="addPlaylist" type="image" src="assets/add.png" width="30" height="30"></input>
        </div>
    </form>

    <?php
    $username = $_SESSION['username'];
    $query = "SELECT id FROM users WHERE username='$username'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row["id"];
    }

    ?>
    <div class="container_playlist_list">
        <h2>Playlists :</h2>
        <div class="playlist_list">
            <?php
            $query = "SELECT * FROM playlists WHERE user_id='$user_id'";
            $result_playlist = mysqli_query($db, $query);
            if (mysqli_num_rows($result_playlist) > 0) {
                while ($row_playlist = mysqli_fetch_assoc($result_playlist)) {
                    $playlist_id = $row_playlist["id"];
                    $playlist_name = $row_playlist["name"];
            ?>
                    <div class="on_one_line">
                        <form class="remove_item" method="post" action="index.php?playlistid=<?php echo $playlist_id ?>">
                            <div>
                                <input type="hidden" name="remove_playlist"></input>
                                <input class="removeLink" type="image" src="assets/remove.png" name="remove_playlist" width="20" height="20"></input>
                            </div>
                        </form>
                        <a class="play_playlist" href="index.php?playlistid=<?php echo $playlist_id ?>&play_playlist=1"><strong><?php echo "$playlist_name"; ?></strong></a>
                        <form method="post" action="index.php?playlistid=<?php echo $playlist_id ?>">
                            <div>
                                <input type="hidden" name="play_playlist"></input>
                                <input type="image" src="<?php if ($_COOKIE['playlist_id'] == $playlist_id) {
                                                                echo "assets/pause.png";
                                                            } else {
                                                                echo "assets/play.png";
                                                            } ?>" width="30" height="30"></input>
                            </div>
                        </form>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>
<?php
$actual_playlist_id = $_COOKIE['playlist_id'];
$query = "SELECT * FROM playlists WHERE user_id='$user_id' AND id='$actual_playlist_id'";
$result_playlist = mysqli_query($db, $query);
if (mysqli_num_rows($result_playlist) > 0) {
    while ($row_playlist = mysqli_fetch_assoc($result_playlist)) {
        $playlist_id = $row_playlist["id"];
        $playlist_name = $row_playlist["name"];
?>
        <li class="playlist">
            <div class="on_one_line">
                <a class="play_playlist" href="index.php?playlistid=<?php echo $playlist_id ?>&play_playlist=1"><strong><?php echo "$playlist_name"; ?></strong></a>
            </div>
            <?php
            $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' ORDER BY exec_order ASC";
            $result_link = mysqli_query($db, $query);
            ?>
            <div class="music_list">
                <?php
                if (mysqli_num_rows($result_link) > 0) {
                    while ($row_names = mysqli_fetch_assoc($result_link)) {
                        $name = $row_names['name'];
                        $link_id = $row_names['id'];
                ?>
                        <div class="on_one_line">
                            <form method="post" action="index.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                <div>
                                    <input type="hidden" name="play_music"></input>
                                    <input id="play_pause_button_<?php echo $link_id; ?>" class="playLink" type="image" src="<?php if ($_COOKIE['link_id'] == $link_id) {
                                                                                                                            echo "assets/pause.png";
                                                                                                                        } else {
                                                                                                                            echo "assets/play.png";
                                                                                                                        } ?>" width="20" height="20"></input>
                                </div>
                            </form>
                            <p><?php
                                if (strlen($name) > 100) {
                                    $name = substr($name, 0, 100);
                                    $name .= "...";
                                }
                                echo "$name";
                                ?></p>
                            <div class="option_link">
                                <form method="post" action="index.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                    <div>
                                        <input type="hidden" name="move_up"></input>
                                        <input class="moveUp" type="image" src="assets/up.png" width="15" height="10"></input>
                                    </div>
                                </form>
                                <form method="post" action="index.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                    <div>
                                        <input type="hidden" name="move_down"></input>
                                        <input class="moveDown" type="image" src="assets/down.png" width="15" height="10"></input>
                                    </div>
                                </form>
                                <form class="remove_item" method="post" action="index.php?linkid=<?php echo $link_id ?>">
                                    <div>
                                        <input type="hidden" name="remove_music"></input>
                                        <input class="removeLink" type="image" src="assets/remove.png" width="12" height="12"></input>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr class="separator">
                        <?php
                    }
                        ?><?php
                        }
                            ?>
            </div>
            <form class="on_one_line" method="post" action="index.php?playlistid=<?php echo $playlist_id ?>">
                <input class="inputLink" type="test" name="link">
                <div class="add_item">
                    <input type="hidden" name="add_link"></input>
                    <input type="image" src="assets/add.png" width="30" height="30"></input>
                </div>
            </form>
        </li> <?php
            }
        }
                ?>