<div class="page">
    <?php if (isset($_SESSION['success'])) :
        include("header.php") ?>
        <div class="content">
            <div class="playlists">
                <?php include('content.php'); ?>
            </div>
        </div>
    <?php include("footer.php");
    endif ?>
</div>