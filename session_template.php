<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

?>

<div class="page">
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="header">
            <a href="index.php?logout='1'">
                <img src="exit.png" height="25" width="30"></img>
            </a>
            <a href="index.php"><img src="logo.png" height="150" width="150"></a>
            <div></div>
        </div>
        <div class="content">
            <?php include('session.php'); ?>
        </div>
        <div class="footer" id="myFooter">
            <div class="info_music">
                <p>XXXTENTACION - School Shooters...</p>
            </div>
            <div id="player">
                <ul>
                    <li>
                        <div class="controls">
                            <i id="prev" class="material-icons">fast_rewind</i>
                            <i id="play_pause" class="material-icons">pause</i>
                            <i id="next" class="material-icons">fast_forward</i>
                        </div>
                        <div class="music_controls">
                            <div class="progress">
                                <div id="time"><span id="current-time">0:00</span> / <span id="duration">0:00</span></div>
                                <input type="range" id="progress-bar" value="0">
                            </div>
                            <div class="volume_controls">
                                <i id="mute-toggle" class="material-icons">volume_up</i>
                                <input id="volume-input" type="range" max="100" min="0">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <script src="https://www.youtube.com/iframe_api"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
            <script type="text/javascript">
                var myPLaylist = <?php echo '["' . implode('", "', $_SESSION['actual_playlist']) . '"]' ?>;
            </script>
            <script type="text/javascript" src="script.js"></script>
        </div>
    <?php endif ?>
</div>