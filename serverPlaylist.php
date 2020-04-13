<?php
session_start();

// connect to database
$db = mysqli_connect('10.97.160.3', 'root', '"K*d0e=a', 'wakoky');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//  create playlist
if (isset($_POST['add_playlist'])) {
    $errors = array();
    // receive all input values from the form
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $username = $_SESSION['username'];
    $query = "SELECT id FROM users WHERE username='$username'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row["id"];
    }

    // form validation: ensure that the form is correctly filled
    if (empty($name)) {
        array_push($errors, "Name is required");
    }

    //check if name used
    $query = "SELECT * FROM playlists WHERE name='$name' AND user_id='$user_id'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 1) {
        array_push($errors, "Name used");
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO playlists (name, user_id) 
					  VALUES('$name', '$user_id')";
        mysqli_query($db, $query);
        header('location: session.php');
    }
}

function youtube_title($id)
{
    $api_key = "AIzaSyB96N_CX-mutJ1SdPcs8QoeoBz2YQJzieg";
    // $id = 'YOUTUBE_ID';
    // returns a single line of JSON that contains the video title. Not a giant request.
    $videoTitle = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=" . $id . "&key=$api_key&fields=items(id,snippet(title),statistics)&part=snippet,statistics");
    // despite @ suppress, it will be false if it fails
    if ($videoTitle) {
        $json = json_decode($videoTitle, true);

        return $json['items'][0]['snippet']['title'];
    } else {
        return false;
    }
}

if (isset($_POST['add_link'])) { // add link to playlist
    $errors = array();
    $link = mysqli_real_escape_string($db, $_POST['link']);

    // form validation: ensure that the form is correctly filled
    if (empty($link)) {
        array_push($errors, "Link is required");
    }
    $rx = '~
  ^(?:https?://)?                           # Optional protocol
   (?:www[.])?                              # Optional sub-domain
   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
   ([^&]{11})                               # Video id of 11 characters as capture group 1
    ~x';

    if (!preg_match($rx, $link, $match)) {
        array_push($errors, "Bad Link");
    }
    $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
    if (empty($video_id[1]))
        $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..
    $video_id = explode("&", $video_id[1]); // Deleting any other params
    $video_id = $video_id[0];
    $playlist_id = $_GET['playlistid'];
    $title = youtube_title($video_id);
    if (empty($title)) {
        array_push($errors, "error");
    }
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' ORDER BY exec_order DESC";
    $result = mysqli_query($db, $query);
    $exec_order = 1;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (isset($row['exec_order']))
            $exec_order = $row['exec_order'] + 1;
    }
    if (count($errors) == 0) {
        $query = "INSERT INTO links (link, playlist_id, name, exec_order) VALUES('$video_id', '$playlist_id', '$title', '$exec_order')";
        mysqli_query($db, $query);
        header('location: session.php');
    }
}

if (isset($_POST['play_playlist'])) { // play_playlist
    $playlist_id = $_GET['playlistid'];
    $_SESSION['actual_playlist'] = [];
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' ORDER BY exec_order ASC";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) <= 0) {
        array_push($errors, "playlist empty");
    } else {
        for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
            $_SESSION['actual_playlist'][$i] = $row["link"];
        };
        header('location: session.php');
    }
}

if (isset($_POST['play_music'])) { // play_music
    $playlist_id = $_GET['playlistid'];
    $link_id = $_GET['linkid'];
    $_SESSION['actual_playlist'] = [];
    $query = "SELECT * FROM links WHERE id='$link_id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $_SESSION['actual_playlist'][0] = $row["link"];
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' AND id not in ($link_id) AND exec_order > $exec_order ORDER BY exec_order ASC";
    $result = mysqli_query($db, $query);
    for ($i = 1; $row = mysqli_fetch_assoc($result); $i++) {
        $_SESSION['actual_playlist'][$i] = $row["link"];
    };
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' AND id not in ($link_id) AND exec_order < $exec_order ORDER BY exec_order ASC";
    $result = mysqli_query($db, $query);
    for ($i = $i; $row = mysqli_fetch_assoc($result); $i++) {
        $_SESSION['actual_playlist'][$i] = $row["link"];
    };
    header('location: session.php');
}

if (isset($_POST['remove_music'])) { // remove_a_music
    $id = $_GET['linkid'];
    $query = "SELECT * FROM links WHERE id = '$id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $playlist_id = $row['playlist_id'];
    $query = "DELETE FROM `links` WHERE `links`.`id` = $id";
    $result = mysqli_query($db, $query);
    $query = "SELECT * FROM links WHERE playlist_id = '$playlist_id' AND exec_order > $exec_order ORDER BY exec_order ASC";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $exec_order = $row['exec_order'] - 1;
        $query = "UPDATE `links` SET `exec_order` = $exec_order WHERE `links`.`id` = $id";
        mysqli_query($db, $query);
    }
    if (count($errors) == 0) {
        header('location: session.php');
    }
}

if (isset($_POST['remove_playlist'])) { // remove_a_playlist
    $playlist_id = $_GET['playlistid'];
    $query = "DELETE FROM `links` WHERE `links`.`playlist_id` = $playlist_id";
    $result = mysqli_query($db, $query);
    $query = "DELETE FROM `playlists` WHERE `playlists`.`id` = $playlist_id";
    $result = mysqli_query($db, $query);
    header('location: session.php');
}

if (isset($_POST['move_up'])) { // move music up in the playlist
    $playlist_id = $_GET['playlistid'];
    $link_id = $_GET['linkid'];
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' AND id = '$link_id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' AND exec_order < '$exec_order' ORDER BY id DESC";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $id_up = $row["id"];
    $exec_order_up = $row["exec_order"];
    $query = "UPDATE `links` SET `exec_order` = $exec_order_up WHERE `links`.`id` = $link_id";
    $result = mysqli_query($db, $query);
    $query = "UPDATE `links` SET `exec_order` = $exec_order WHERE `links`.`id` = $id_up";
    $result = mysqli_query($db, $query);
    if (count($errors) == 0) {
        header('location: session.php');
    }
}

if (isset($_POST['move_down'])) { // move the music down in the playlist
    $playlist_id = $_GET['playlistid'];
    $link_id = $_GET['linkid'];
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' AND id = '$link_id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $exec_order = $row['exec_order'];
    $query = "SELECT * FROM links WHERE playlist_id='$playlist_id' AND exec_order > '$exec_order' ORDER BY id ASC";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $id_down = $row["id"];
    $exec_order_down = $row["exec_order"];
    $query = "UPDATE `links` SET `exec_order` = $exec_order_down WHERE `links`.`id` = $link_id";
    mysqli_query($db, $query);
    $query = "UPDATE `links` SET `exec_order` = $exec_order WHERE `links`.`id` = $id_down";
    mysqli_query($db, $query);
    if (count($errors) == 0) {
        header('location: session.php');
    }
}
