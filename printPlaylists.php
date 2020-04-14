<?php
session_start();
?>

<?php
$username = $_SESSION['username'];
$query = "SELECT id FROM users WHERE username='$username'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["id"];
}

$query = "SELECT * FROM playlists WHERE user_id='$user_id'";
$result_playlist = mysqli_query($db, $query);
if (mysqli_num_rows($result_playlist) > 0) {
    while ($row_playlist = mysqli_fetch_assoc($result_playlist)) {
        $playlist_id = $row_playlist["id"];
        $playlist_name = $row_playlist["name"];
?>
        <li class="playlist">
            <div class="on_one_line">
                <form class="remove_item" method="post" action="session.php?playlistid=<?php echo $playlist_id ?>">
                    <div>
                        <input type="hidden" name="remove_playlist"></input>
                        <input class="removeLink" type="image" src="remove.png" name="remove_playlist" width="40" height="40"></input>
                    </div>
                </form>
                <h3><?php echo "$playlist_name"; ?></h3>
                <div></div>
                <div></div>
            </div>
            <?php
            $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' ORDER BY exec_order";
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
                            <form method="post" action="session.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                <div>
                                    <input type="hidden" name="play_music"></input>
                                    <input class="playLink" type="image" src="play.png" name="play_music" width="30" height="30"></input>
                                </div>
                            </form>
                            <?php
                            if (strlen($name) > 30) {
                                $name = substr($name, 0, 30);
                                $name .= "...";
                            }
                            echo "$name";
                            ?>
                            <div class="option_link">
                                <form method="post" action="session.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                    <div>
                                        <input type="hidden" name="move_up"></input>
                                        <input class="moveUp" type="image" src="up.png" name="move_up" width="30" height="30"></input>
                                    </div>
                                </form>
                                <form method="post" action="session.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                    <div>
                                        <input type="hidden" name="move_down"></input>
                                        <input class="moveDown" type="image" src="down.png" name="move_down" width="30" height="30"></input>
                                    </div>
                                </form>
                                <form class="remove_item" method="post" action="session.php?linkid=<?php echo $link_id ?>">
                                    <div>
                                        <input type="hidden" name="remove_music"></input>
                                        <input class="removeLink" type="image" src="remove.png" name="remove_music" width="30" height="30"></input>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                        ?><?php
                        }
                            ?>
            </div>
            <form class="on_one_line" method="post" action="session.php?playlistid=<?php echo $playlist_id ?>">
                <input class="inputLink" type="test" name="link">
                <div class="add_item">
                    <input type="hidden" name="add_link"></input>
                    <input class="addLink" type="image" src="add.png" name="add_link" width="40" height="40"></input>
                </div>
            </form>
            <form method="post" action="session.php?playlistid=<?php echo $playlist_id ?>">
                <div>
                    <input type="hidden" name="play_playlist"></input>
                    <input class="addLink" type="image" src="play.png" name="play_playlist" width="40" height="40"></input>
                </div>
            </form>
        </li> <?php
            }
        }
                ?>