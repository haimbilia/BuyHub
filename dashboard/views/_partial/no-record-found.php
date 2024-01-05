<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="block-empty text-center noRecordFoundJs">
    <img class="block__img" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/errors/empty_item.svg" alt="<?php echo Labels::getLabel('LBL_NO_RECORD_FOUND'); ?>" width="150px">
    <h5>
        <?php echo $message ?? Labels::getLabel('LBL_NO_RECORD_FOUND');?>
    </h5>
    <?php if (!empty($linkArr)) {
        foreach ($linkArr as $link) {
            $onclick = isset($link['onclick']) ? "onclick='" . $link['onclick'] . "'" : "";
            echo "<a href='" . $link['href'] . "' class='btn btn-brand btn-sm'" . $onclick .  ">" . $link['label'] . "</a>";
        }
    } ?>
</div>
<script>
    $(".formActionBtn-js").addClass("disabled");
</script>