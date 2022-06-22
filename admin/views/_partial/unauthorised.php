<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="col-md-12 noRecordFoundJs">
    <div class="card card-stretch mb-0">
        <div class="card-body">
            <div class="not-found">
                <img width="100" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">
                <h3><?php echo Labels::getLabel('MSG_UNAUTHORISED_ACCESS!'); ?></h3>
                <p><?php echo CommonHelper::replaceStringData(Labels::getLabel('MSG_PLEASE_CONTACT_ADMIN_{BUSINESS-EMAIL}'), ['{BUSINESS-EMAIL}' => '<a target="_blank" href="mailto: ' . FatApp::getConfig("CONF_SITE_OWNER_EMAIL") . '">' . FatApp::getConfig("CONF_SITE_OWNER_EMAIL")]) . '</a>'; ?></p>
            </div>
        </div>
    </div>
</div>