<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $data['earch_subject']; ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="row">
            <div class="col-md-12">
                <ul class="list-stats list-stats-double">
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_TEMPLATE_NAME', $siteLangId); ?></span>
                        <span class="value"><?php echo $data['earch_tpl_name']; ?></span>
                    </li>
                    <?php if (!empty($data['earch_sent_on'])) { ?>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_SENT_ON', $siteLangId); ?></span>
                            <span class="value">
                                <?php echo HtmlHelper::formatDateTime((string)$data['earch_sent_on'], true, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())); ?>
                            </span>
                        </li>
                    <?php } ?>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_SENT_TO', $siteLangId); ?></span>
                        <span class="value"><?php echo $data['earch_to_email']; ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <?php echo CommonHelper::renderHtml($data['earch_body'], true); ?>
            </div>
        </div>
    </div>
</div>