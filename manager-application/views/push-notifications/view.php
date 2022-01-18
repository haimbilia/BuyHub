<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $data['pnotification_title']; ?>
    </h5>
</div>
<div class="modal-body">
    <div class="form-edit-body">
        <ul class="list-stats">
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_STATUS', $siteLangId); ?>:</span>
                <span class="value"><?php echo PushNotification::getStatusHtml($siteLangId, $data['pnotification_status']); ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_SELECTED_LANGUAGE', $siteLangId); ?>:</span>
                <span class="value"><?php echo $languages[$data['pnotification_lang_id']]['language_name']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('FRM_NOTIFICATION_FOR_(USERS)', $siteLangId); ?>:</span>
                <span class="value">
                    <?php echo PushNotification::getAuthTypeHtml($siteLangId, $data['pnotification_user_auth_type']); ?>
                </span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_SCHEDULE_DATE', $siteLangId); ?>:</span>
                <span class="value">
                    <?php echo HtmlHelper::formatDateTime($data['pnotification_notified_on'], true, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())); ?>
                </span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_DEVICE_TYPE', $siteLangId); ?>:</span>
                <span class="value">
                    <?php echo PushNotification::getDeviceTypeHtml($siteLangId, $data['pnotification_device_os']); ?>
                </span>
            </li>
            <?php if (!empty($data['pnotification_url'])) { ?>
                <li class="list-stats-item">
                    <span class="lable"><?php echo Labels::getLabel('LBL_URL', $siteLangId); ?>:</span>
                    <span class="value">
                        <?php echo $data['pnotification_url']; ?>
                    </span>
                </li>
            <?php } ?>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_BODY', $siteLangId); ?>:</span>
                <span class="value"><?php echo $data['pnotification_description']; ?></span>
            </li>
        </ul>
    </div>
</div>