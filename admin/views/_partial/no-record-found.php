<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$message = $message ?? '';
?>
<div class="col-md-12 noRecordFoundJs">
    <div class="card card-stretch mb-0">
        <div class="card-body">
            <div class="not-found">
                <img width="100" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">
                <?php if (empty($message)) {?>
                    <h3><?php echo Labels::getLabel('MSG_SORRY,_NO_MATCHING_RESULT_FOUND'); ?></h3>
                    <p><?php echo Labels::getLabel('MSG_TRY_CHECKING_YOUR_SPELLING_OR_USER_MORE_GENERAL_TERMS'); ?></p>
                <?php } else { ?>
                    <h3><?php echo $message; ?></h3>
                <?php } ?>
            </div>
        </div>
    </div>
</div>