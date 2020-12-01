<?php
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: signIn');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    foreach ($_COOKIE as $cookie_name => $cookie_value) {
        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, '', time() - 4200, '/');
    }
    header("location: signIn");
}

if (isset($_GET['error'])) {
?>
    <script>
        alert("<?php echo htmlspecialchars($_GET['error'], ENT_QUOTES); ?>")
    </script>
<?php
}
if (isset($_COOKIE['playing']) && isset($_COOKIE['loaded'])) {
    if ($_COOKIE['playing'] == '1' && $_COOKIE['loaded'] == '0' && isset($_COOKIE['playlist_id']) && isset($_COOKIE['link_id']))
        reload_playlist();
}
?>