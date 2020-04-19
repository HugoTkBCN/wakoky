<?php

function print_input_link($playlist_id)
{ ?>
    <form class="on_one_line" method="post" action="index.php?playlistid=<?php echo $playlist_id ?>">
        <input class="inputLink" type="test" name="link">
        <div class="add_item">
            <input type="hidden" name="add_link"></input>
            <input type="image" src="assets/add.png" width="30" height="30"></input>
        </div>
    </form>
<?php
}

function print_options($playlist_id, $link_id)
{ ?>
    <?php print_button("", "index.php?playlistid=$playlist_id&linkid=$link_id", "move_up", "15", "10", "moveUp", "assets/up.png"); ?>
    <?php print_button("", "index.php?playlistid=$playlist_id&linkid=$link_id", "move_down", "15", "10", "moveDown", "assets/down.png"); ?>
    <?php print_button("remove_item", "index.php?linkid=$link_id", "remove_music", "12", "12", "removeLink", "assets/remove.png"); ?>
    <?php
}

function print_musics($playlist_id, $db)
{
    $result_link = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' ORDER BY exec_order ASC", $db);
    if (mysqli_num_rows($result_link) <= 0)
        return;
    while ($row_names = mysqli_fetch_assoc($result_link)) {
        $name = $row_names['name'];
        $link_id = $row_names['id']; ?>
        <div class="on_one_line">
            <form method="post" action="index.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                <div>
                    <input type="hidden" name="play_music"></input>
                    <input id="play_pause_button_<?php echo $link_id; ?>" class="playLink" type="image" src="<?php echo get_button($link_id, 'link_id') ?>" width="20" height="20"></input>
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
                <?php print_options($playlist_id, $link_id); ?>
            </div>
        </div>
        <hr class="separator">
    <?php
    } ?>
<?php
}

$actual_playlist_id = $_COOKIE['playlist_id'];
$result_playlist = exec_query("SELECT * FROM playlists WHERE user_id='$user_id' AND id='$actual_playlist_id'", $db);
if (mysqli_num_rows($result_playlist) > 0) {
    $row_playlist = mysqli_fetch_assoc($result_playlist);
    $playlist_id = $row_playlist["id"];
    $playlist_name = $row_playlist["name"]; ?>
    <div class="playlist">
        <h2 class="title_playlist"><strong><?php echo "$playlist_name"; ?></strong></h2>
        <div class="music_list">
            <?php print_musics($playlist_id, $db); ?>
        </div>
        <?php print_input_link($playlist_id); ?>
    </div>
<?php
}
?>