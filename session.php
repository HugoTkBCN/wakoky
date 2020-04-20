<div class="page">
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="header">
            <?php include("header") ?>
        </div>
        <div class="content">
            <div class="playlists">
                <?php include('content'); ?>
            </div>
        </div>
        <div class="footer" id="myFooter">
            <?php include("footer"); ?>
        </div>
    <?php endif ?>
</div>