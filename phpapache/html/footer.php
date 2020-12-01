<div class="info_music">
    <div id="title"></div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
<?php if ($_SESSION['actual_playlist'] && $_SESSION['actual_playlist_id']) {
?><script type="text/javascript">
        var myPLaylist = <?php echo '["' . implode('", "', $_SESSION['actual_playlist']) . '"]' ?>;
        var myPLaylistId = <?php echo '["' . implode('", "', $_SESSION['actual_playlist_id']) . '"]' ?>;
    </script>
<?php } ?>
<script type="text/javascript" src="scripts/script.js"></script>