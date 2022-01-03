<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$recordId = $badgeReqId;

$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0], "closeForm"); return(false);');
if (BadgeLinkCondition::RECORD_TYPE_SHOP != $breqRecordType) {
    $fld = $frm->getField('badgelink_record_ids[]');
    if (null != $fld) {
        $fld->addFieldTagAttribute('id', 'recordIdJs');
        $fld->addFieldTagAttribute('multiple', true);
        $fld->addFieldTagAttribute('data-allow-clear', false);
    }
}

$fld = $frm->getField('breq_message');
$fld->addFieldTagAttribute('disabled', 'disabled');

$fld = $frm->getField('link_type');
if (1 > $badgeReqId) {
    $fld->setWrapperAttribute('class', 'd-none');
} else if (BadgeLinkCondition::RECORD_TYPE_SHOP == $breqRecordType) {
    $shop = $this->includeTemplate('_partial/shop/shop-info-card.php', ['shop' => $shopData, 'siteLangId' => $siteLangId], false, true);
    $htm = '<div class="col-md-12">
                <div class="form-group">
                    <label class="label">' . Labels::getLabel('LBL_RECORD_TYPE', $siteLangId) . '</label>
                    <div>' . $shop . '</div>
                </div>
            </div>';
    $fld->value = $htm;
} else if (BadgeLinkCondition::RECORD_TYPE_PRODUCT == $breqRecordType) {
    $htm = '<div class="col-md-12">
                <div class="form-group">
                    <label class="label">' . Labels::getLabel('LBL_RECORD_TYPE', $siteLangId) . '</label>
                    <div><span class="badge badge-info">' . Labels::getLabel('LBL_PRODUCT', $siteLangId) . '</span></div>
                </div>
            </div>';
    $fld->value = $htm;
} else {
    $htm = '<div class="col-md-12">
                <div class="form-group">
                    <label class="label">' . Labels::getLabel('LBL_RECORD_TYPE', $siteLangId) . '</label>
                    <div><span class="badge badge-success">' . Labels::getLabel('LBL_SELLER_PRODUCT', $siteLangId) . '</span></div>
                </div>
            </div>';
    $fld->value = $htm;
}

$fld = $frm->getField('request_ref');
if (false === $fileFound) {
    $fld->setWrapperAttribute('class', 'd-none');
} else {
    $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
    $uploadedTime = AttachedFile::setTimeParam($res['afile_updated_at']);
    $a = '<a target="blank" title="' . Labels::getLabel('LBL_DOWNLOAD_FILE', $siteLangId) . '" href="' . UrlHelper::generateUrl('BadgeRequests', 'downloadFile', array($badgeReqId)) . '">
        <img src="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeRequest', [$badgeReqId, 1500, 50]) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '" />
    </a>';

    $htm = '<div class="col-md-12">
                <div class="form-group">
                    <label class="label">' . Labels::getLabel('LBL_REQUEST_REFERENCE', $siteLangId) . '</label>
                    <div>' . $a . '</div>
                </div>
            </div>';

    $fld->value = $htm;
}
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
    var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;
    $(function() {
        bindRecordsSelect2();
    });
</script>