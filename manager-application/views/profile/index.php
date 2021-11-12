<main class="main">
    <div class="container">
        <?php require_once CONF_THEME_PATH . 'profile/leftSideBar.php'; ?>
        <div class="row justify-content-center">
            <div class="col-lg-6" id="mainProfileBlockJs">
            </div>
        </div>
    </div>
</main>
<script>
var cropperHeading = '<?php echo Labels::getLabel('LBL_PROFILE_IMAGE', $siteLangId); ?>';
$(document).ready(function() {
    openProfileTab("<?php echo $tab ?>");
});
</script>