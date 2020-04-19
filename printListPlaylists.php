<?php
function print_button($form_class, $action, $name, $width, $height, $img_class, $src)
{ ?>
    <form class="<?php echo $form_class ?>" method="post" action="<?php echo $action ?>">
        <div>
            <input type="hidden" name="<?php echo $name ?>"></input>
            <input class="<?php echo $img_class ?>" type="image" src="<?php echo $src ?>" name="<?php echo $name ?>" width="<?php echo $width ?>" height="<?php echo $height ?>"></input>
        </div>
    </form>
<?php
}

function get_button($id, $type)
{
    if (isset($_COOKIE[$type])) {
        if ($_COOKIE[$type] == $id)
            return ("assets/pause.png");
        else
            return ("assets/play.png");
    }
    return ("assets/play.png");
}

$username = $_SESSION['username'];
$user_id = $_SESSION["user_id"];
?>

<h2>Playlists :</h2>
<div class="playlist_list">
    <?php
    $result_playlist = exec_query("SELECT * FROM playlists WHERE user_id='$user_id'", $db);
    if (mysqli_num_rows($result_playlist) > 0) {
        while ($row_playlist = mysqli_fetch_assoc($result_playlist)) {
            $playlist_id = $row_playlist["id"];
            $playlist_name = $row_playlist["name"]; ?>
            <div class="on_one_line">
                <?php print_button("remove_item", "index.php?playlistid=$playlist_id", "remove_playlist", "20", "20", "removeLink", "assets/remove.png"); ?>
                <a class="play_playlist" href="index.php?playlistid=<?php echo $playlist_id ?>&play_playlist=1"><strong><?php echo "$playlist_name"; ?></strong></a>
                <?php print_button("", "index.php?playlistid=$playlist_id", "play_playlist", "30", "30", "", get_button($playlist_id, 'playlist_id')); ?>
            </div>
    <?php }
    } ?>
</div>