<?php
session_start();

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
        <div class="playlist">
            <p><?php echo "Name: $playlist_name"; ?> </p>
            <?php
            $query = "SELECT * FROM links WHERE playlist_id='$playlist_id'";
            $result_link = mysqli_query($db, $query);
            ?>
            <p><?php echo "Musics: "; ?> </p>
            <?php
            if (mysqli_num_rows($result_link) > 0) {
                while ($row_names = mysqli_fetch_assoc($result_link)) {
                    $name = $row_names['name'];
                    $link_id = $row_names['id'];
            ?>
                    <div class="music_line">
                        <?php
                        echo "- $name";
                        ?>
                        <form class="add_item" method="post" action="session.php?linkid=<?php echo $link_id ?>">
                            <div>
                                <button type="submit" name="remove_music">remove</button>
                            </div>
                        </form>
                    </div>
            <?php
                }
            }
            ?>
            <form class="add" method="post" action="session.php?playlistid=<?php echo $playlist_id ?>">
                <div class="add_item">
                    <label>link: </label>
                    <input type="test" name="link">
                </div>
                <div class="add_item">
                    <button type="submit" name="add_link">add music</button>
                </div>
            </form>
            <form method="post" action="session.php?playlistid=<?php echo $playlist_id ?>">
                <div>
                    <button type="submit" name="play">play</button>
                </div>
            </form>
        </div> <?php
            }
        }
                ?>