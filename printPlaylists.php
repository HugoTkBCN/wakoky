<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Session</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/tomorrow.min.css">
</head>

<body>
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
                    <p><?php echo "Name: $playlist_name"; ?></p>
                    <form class="remove_item" method="post" action="session.php?playlistid=<?php echo $playlist_id ?>">
                        <div>
                            <button type="submit" name="remove_playlist">remove</button>
                        </div>
                    </form>
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
                                        <button type="submit" name="play_music">play</button>
                                    </div>
                                </form>
                                <?php
                                if (strlen($name) > 30) {
                                    $name = substr($name, 0, 30);
                                    $name .= "...";
                                }
                                echo "$name";
                                ?>
                                <form class="remove_item" method="post" action="session.php?linkid=<?php echo $link_id ?>">
                                    <div>
                                        <button type="submit" name="remove_music">remove</button>
                                    </div>
                                </form>
                                <form method="post" action="session.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                    <div>
                                        <button type="submit" name="move_up">up</button>
                                    </div>
                                </form>
                                <form method="post" action="session.php?playlistid=<?php echo $playlist_id ?>&linkid=<?php echo $link_id ?>">
                                    <div>
                                        <button type="submit" name="move_down">down</button>
                                    </div>
                                </form>
                            </div>
                            <?php
                        }
                            ?><?php
                            }
                                ?>
                </div>
                <form class="on_one_line" method="post" action="session.php?playlistid=<?php echo $playlist_id ?>">
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
                        <button type="submit" name="play_playlist">play</button>
                    </div>
                </form>
            </li> <?php
                }
            }
                    ?>
</body>

</html>