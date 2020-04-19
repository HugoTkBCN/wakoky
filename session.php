<div class="page">
    <div>
        <?php if (isset($_SESSION['success'])) :
            include("header.php") ?>
    </div>
    <div class="content">
        <div class="playlists">
            <?php include('content.php'); ?>
        </div>
    </div>
    <div>
        <?php include("footer.php"); ?>
    </div>
<?php endif ?>
</div>