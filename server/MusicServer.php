<?php
#################################################
############  Connect to database  ##############
#################################################

function connect_to_database()
{
    $db = mysqli_connect('localhost', 'root', '"K*d0e=A', 'wakoky');
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return ($db);
}

$db = connect_to_database();

#################################################
############   Utils Function  ##################
#################################################

function exec_query($query, $db)
{
    return (mysqli_query($db, $query));
}

function reload_playlist()
{
    $db = connect_to_database();
    $playlist_id = $_COOKIE['playlist_id'];
    $link_id = $_COOKIE['link_id'];

    $result = exec_query("SELECT * FROM links WHERE id='$link_id'", $db);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $tmp = [];
    $tmp[0] = $link_id;

    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND id not in ($link_id) AND exec_order > $exec_order ORDER BY exec_order ASC", $db);
    for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) {
        $tmp[$i] = $row["id"];
    };
    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND id not in ($link_id) AND exec_order < $exec_order ORDER BY exec_order ASC", $db);
    for ($i = $i; $row = mysqli_fetch_assoc($result); $i++) {
        $tmp[$i] = $row["id"];
    };
    $link_id = $tmp[$_COOKIE['order'] - 1];
?>
    <form method="post" action="/?reload=1&at_time=1&playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>" id="load">
        <input type="hidden" name="play_music"></input>
    </form>
    <script type="text/javascript">
        document.getElementById('load').submit();
    </script>
<?php
}

function get_youtube_title($id)
{
    $api_key = "AIzaSyB96N_CX-mutJ1SdPcs8QoeoBz2YQJzieg";
    $videoTitle = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=" . $id . "&key=$api_key&fields=items(id,snippet(title),statistics)&part=snippet,statistics");
    if ($videoTitle) {
        $json = json_decode($videoTitle, true);
        return $json['items'][0]['snippet']['title'];
    } else
        return "";
}

function get_id($link)
{
    $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
    if (empty($video_id[1]))
        $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..
    $video_id = explode("&", $video_id[1]); // Deleting any other params
    $video_id = $video_id[0];
    return ($video_id);
}

function unset_cookie($name)
{
    unset($_COOKIE[$name]);
    setcookie($name, '', time() - 4200, '/');
}

#################################################
############  Create Playlist  ##################
#################################################

if (isset($_POST['add_playlist'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $username = $_SESSION['username'];

    $result = exec_query("SELECT id FROM users WHERE username='$username'", $db);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row["id"];
    }
    if (empty($name))
        header('location: /?error=Name is required');
    else {
        $result = exec_query("SELECT * FROM playlists WHERE name='$name' AND user_id='$user_id'", $db);
        if (mysqli_num_rows($result) == 1)
            header('location: /?error=Name used');
        else {
            $result = exec_query("INSERT INTO playlists (name, user_id) 
					  VALUES('$name', '$user_id')", $db);
        }
    }
    header('location: /');
}

#################################################
############ Add Link to playlist ###############
#################################################


if (isset($_POST['add_link'])) {
    $link = mysqli_real_escape_string($db, $_POST['link']);
    $playlist_id =  mysqli_real_escape_string($db, $_GET['playlistid']);

    if (empty($link) || empty($playlist_id))
        header('location: /?error=Link is required');
    else {
        $rx = '~
  ^(?:https?://)?                           # Optional protocol
   (?:www[.])?                              # Optional sub-domain
   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
   ([^&]{11})                               # Video id of 11 characters as capture group 1
    ~x';
        if (!preg_match($rx, $link, $match))
            header('location: /?error=Bad Link');
        else {
            $video_id = get_id($link);
            if (empty($video_id)) {
                $ytshorturl = 'youtu.be/';
                $ytlongurl = 'www.youtube.com/watch?v=';
                $link = str_replace($ytshorturl, $ytlongurl, $link);
                $video_id = get_id($link);
            }
            $title = get_youtube_title($video_id);
            $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' ORDER BY exec_order DESC", $db);
            $exec_order = 1;
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (isset($row['exec_order']))
                    $exec_order = $row['exec_order'] + 1;
            }
            $result = exec_query("INSERT INTO links (link, playlist_id, name, exec_order) VALUES('$video_id', '$playlist_id', '$title', '$exec_order')", $db);
        }
    }
    header('location: /');
}

#################################################
############   Play playlist   ##################
#################################################

function play_playlist($playlist_id, $db)
{
    $_COOKIE['playlist_id'] = $playlist_id;
    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' ORDER BY exec_order ASC", $db);
    for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
        if ($i == 0)
            $link_id = $row['id'];
        $_SESSION['actual_playlist'][$i] = $row["link"];
        $_SESSION['actual_playlist_id'][$i] = $row["id"];
    };
    setcookie('playlist_id', $playlist_id, time() + (86400 * 30), "/");
    setcookie('link_id', $link_id, time() + (86400 * 30), "/");
    setcookie('loaded', '1', time() + (86400 * 30), "/");
    setcookie('time', '0', time() + (86400 * 30), "/");
}

if (isset($_GET['play_playlist']) || isset($_POST['play_playlist'])) {
    $_SESSION['actual_playlist'] = [];
    $_SESSION['actual_playlist_id'] = [];
    $playlist_id =  mysqli_real_escape_string($db, $_GET['playlistid']);
    if (isset($_COOKIE['playlist_id'])) {
        if ($_COOKIE['playlist_id'] == $playlist_id) {
            unset_cookie('playlist_id');
            unset_cookie('link_id');
            unset_cookie('loaded');
            unset_cookie('time');
        } else
            play_playlist($playlist_id, $db);
    } else
        play_playlist($playlist_id, $db);
    header('location: /');
}

#################################################
#### Play playlist but start at music ###########
#################################################

function play_music($link_id, $playlist_id, $db)
{
    $result = exec_query("SELECT * FROM links WHERE id='$link_id'", $db);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $_SESSION['actual_playlist'][0] = $row["link"];
    $_SESSION['actual_playlist_id'][0] = $row["id"];
    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND id not in ($link_id) AND exec_order > $exec_order ORDER BY exec_order ASC", $db);
    for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) {
        $_SESSION['actual_playlist'][$i] = $row["link"];
        $_SESSION['actual_playlist_id'][$i] = $row["id"];
    };
    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND id not in ($link_id) AND exec_order < $exec_order ORDER BY exec_order ASC", $db);
    for ($i = $i; $row = mysqli_fetch_assoc($result); $i++) {
        $_SESSION['actual_playlist'][$i] = $row["link"];
        $_SESSION['actual_playlist_id'][$i] = $row["id"];
    };
    setcookie('playlist_id', $playlist_id, time() + (86400 * 30), "/");
    setcookie('link_id', $link_id, time() + (86400 * 30), "/");
    setcookie('loaded', '1', time() + (86400 * 30), "/");
    if (!isset($_GET['at_time']))
        setcookie('time', '0', time() + (86400 * 30), "/");
}

if (isset($_POST['play_music']) || isset($_GET['play_music'])) {
    $_SESSION['actual_playlist'] = [];
    $_SESSION['actual_playlist_id'] = [];
    $playlist_id =  mysqli_real_escape_string($db, $_GET['playlistid']);
    $link_id =  mysqli_real_escape_string($db, $_GET['linkid']);
    if (isset($_COOKIE['playlist_id']) && isset($_COOKIE['link_id']) && !isset($_GET['reload'])) {
        if ($_COOKIE['playlist_id'] == $playlist_id && $_COOKIE['link_id'] == $link_id) {
            unset_cookie('link_id');
            unset_cookie('loaded');
            unset_cookie('time');
        } else
            play_music($link_id, $playlist_id, $db);
    } else
        play_music($link_id, $playlist_id, $db);
    header('location: /');
}

#################################################
######## Remove music from playlist #############
#################################################

if (isset($_POST['remove_music'])) {
    $id =  mysqli_real_escape_string($db, $_GET['linkid']);
    $result = exec_query("SELECT * FROM links WHERE id = '$id'", $db);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $playlist_id = $row['playlist_id'];
    $result = exec_query("DELETE FROM `links` WHERE `links`.`id` = $id", $db);
    $result = exec_query("SELECT * FROM links WHERE playlist_id = '$playlist_id' AND exec_order > $exec_order ORDER BY exec_order ASC", $db);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $exec_order = $row['exec_order'] - 1;
        exec_query("UPDATE `links` SET `exec_order` = $exec_order WHERE `links`.`id` = $id", $db);
    }
    header('location: /');
}

#################################################
############  Remove Playlist  ##################
#################################################

if (isset($_POST['remove_playlist'])) {
    $playlist_id =  mysqli_real_escape_string($db, $_GET['playlistid']);
    $result = exec_query("DELETE FROM `links` WHERE `links`.`playlist_id` = $playlist_id", $db);
    $result = exec_query("DELETE FROM `playlists` WHERE `playlists`.`id` = $playlist_id", $db);
    header('location: /');
}

#################################################
###########  Move music in playlist  ############
#################################################

if (isset($_POST['move_up'])) { // move music up in the playlist
    $playlist_id =  mysqli_real_escape_string($db, $_GET['playlistid']);
    $link_id =  mysqli_real_escape_string($db, $_GET['linkid']);

    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND id = '$link_id'", $db);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $exec_order_up = $exec_order - 1;

    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND exec_order='$exec_order_up'", $db);
    $row = mysqli_fetch_assoc($result);
    $id_up = $row["id"];

    $result = exec_query("UPDATE `links` SET `exec_order` = $exec_order_up WHERE `links`.`id` = $link_id", $db);
    $result = exec_query("UPDATE `links` SET `exec_order` = $exec_order WHERE `links`.`id` = $id_up", $db);
    header('location: /');
}

if (isset($_POST['move_down'])) { // move the music down in the playlist
    $playlist_id =  mysqli_real_escape_string($db, $_GET['playlistid']);
    $link_id =  mysqli_real_escape_string($db, $_GET['linkid']);

    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND id = '$link_id'", $db);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $exec_order_down = $exec_order + 1;

    $result = exec_query("SELECT * FROM links WHERE playlist_id='$playlist_id' AND exec_order='$exec_order_down'", $db);
    $row = mysqli_fetch_assoc($result);
    $id_down = $row["id"];

    $result = exec_query("UPDATE `links` SET `exec_order` = $exec_order_down WHERE `links`.`id` = $link_id", $db);
    $result = exec_query("UPDATE `links` SET `exec_order` = $exec_order WHERE `links`.`id` = $id_down", $db);
    header('location: /');
}
