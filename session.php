<div class="page">
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="header">
            <?php include("header.php") ?>
        </div>
        <div class="content">
            <div class="playlists">
                <?php include('content.php'); ?>
            </div>
        </div>
        <div class="footer" id="myFooter">
            <?php include("footer.php"); ?>
        </div>
    <?php endif ?>
</div>