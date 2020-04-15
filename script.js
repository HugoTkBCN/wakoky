var player,
    time_update_interval = 0;
var playing = -1;

function onYouTubeIframeAPIReady() {
    document.cookie = "numberMusic=" + myPLaylist.length;
    firstVideo = myPLaylist[0];
    myPLaylist.shift();
    myPLaylist = myPLaylist.join(",");
    player = new YT.Player('video-placeholder', {
        width: 0,
        height: 0,
        videoId: firstVideo,
        playerVars: {
            'autoplay': 1,
            'controls': 0,
            'loop': 1,
            'disablekb': 1,
            'cc_load_policy': 1,
            'iv_load_policy': 3,
            'modestbranding': 1,
            'playsinline': 1,
            'enablecastapi': 0,
            'rel': 0,
            'showinfo': 0,
            'html5': 1,
            'forcenewui': 1,
            'enablejsapi': 1,
            playlist: myPLaylist
        },
        events: {
            onReady: initialize,
            onError: checkError,
            onStateChange: onPlayerStateChange

        }
    });
}

function accessCookie(cookieName) {
    var name = cookieName + "=";
    var allCookieArray = document.cookie.split(';');
    for (var i = 0; i < allCookieArray.length; i++) {
        var temp = allCookieArray[i].trim();
        if (temp.indexOf(name) == 0)
            return temp.substring(name.length, temp.length);
    }
    return "";
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {
        var order = parseInt(accessCookie("order")) + 1;
        document.cookie = "order=" + order;
    }
}

function checkError() {
    alert("Can not read this musique");
}

function initialize() {

    // Update the controls on load
    player.seekTo(parseInt(accessCookie('time')));
    updateTimerDisplay();
    updateProgressBar();

    // Clear any old interval.
    clearInterval(time_update_interval);

    // Start interval to update elapsed time display and
    // the elapsed part of the progress bar every second.
    time_update_interval = setInterval(function () {
        updateTimerDisplay();
        updateProgressBar();
    }, 1000);

    document.cookie = "playing=1";
    playing = 1;
    player.setPlaybackQuality("small");
    document.cookie = "order=1";

    $('#volume-input').val(Math.round(player.getVolume()));
}


// This function is called by initialize()
function updateTimerDisplay() {
    // Update current time text display.
    $('#current-time').text(formatTime(player.getCurrentTime()));
    $('#duration').text(formatTime(player.getDuration()));
    document.cookie = "loaded=0";
    document.cookie = "time=" + player.getCurrentTime();
}


// This function is called by initialize()
function updateProgressBar() {
    // Update the value of our progress bar accordingly.
    $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
}

// Progress bar

$('#progress-bar').on('mouseup touchend', function (e) {

    // Calculate the new time for the video.
    // new time in seconds = total duration in seconds * ( value of range input / 100 )
    var newTime = player.getDuration() * (e.target.value / 100);

    // Skip video to new time.
    player.seekTo(newTime);
});


// Playback

$('#play_pause').on('click', function () {
    var play_pause = $(this);
    if (playing == 0) {
        player.playVideo();
        playing = 1;
        play_pause.text('pause');
    } else if (playing == 1) {
        player.pauseVideo();
        playing = 0;
        play_pause.text('play_arrow');
    }
});


// Sound volume


$('#mute-toggle').on('click', function () {
    var mute_toggle = $(this);

    if (player.isMuted()) {
        player.unMute();
        mute_toggle.text('volume_up');
    } else {
        player.mute();
        mute_toggle.text('volume_off');
    }
});

$('#volume-input').on('change', function () {
    player.setVolume($(this).val());
});


// Playlist

$('#next').on('click', function () {
    player.nextVideo();
    var order = parseInt(accessCookie("order")) + 1;
    document.cookie = "order=" + order;
});

$('#prev').on('click', function () {
    player.previousVideo();
    var order = parseInt(accessCookie("order"));
    if (order - 1 < 1)
        order = parseInt(accessCookie("numberMusic")) - 1;
    else
        order -= 1;
    document.cookie = "order=" + order;
});


// Load video

$('.thumbnail').on('click', function () {

    var url = $(this).attr('data-video-id');

    player.cueVideoById(url);
});


// Helper Functions

function formatTime(time) {
    time = Math.round(time);

    var minutes = Math.floor(time / 60),
        seconds = time - minutes * 60;

    seconds = seconds < 10 ? '0' + seconds : seconds;

    return minutes + ":" + seconds;
}


$('pre code').each(function (i, block) {
    hljs.highlightBlock(block);
});