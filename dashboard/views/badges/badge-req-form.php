<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addBadgeReqForm(" . $badgeReqId . ", " . $badgeId . ")");
$frm->setFormTagAttribute('onsubmit', 'setupBadgeReq(this); return(false);');

$fld = $frm->getField('blinkcond_from_date');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('blinkcond_to_date');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('badgelink_record_id');
if (null != $fld) {
    $fld->developerTags['col'] = 8;
    $fld->htmlAfterField = '<div class="recordsContainer--js p-0 box--scroller"></div>';
}

$fld = $frm->getField('breq_message');
if (null != $fld) {
    $fld->developerTags['col'] = 4;
}

$fld = $frm->getField('breq_file');
if (null != $fld) {
    $fld->addFieldTagAttribute('class', 'btn btn-brand btn-sm fileUpload--js');
    $fld->htmlAfterField = '<small class="form-text text-muted">' . Labels::getLabel('LBL_BADGE_REQUEST_REFERENCE_FILE', $siteLangId) . '</small>';
    if (0 < $badgeReqId && true === $fileFound) {
        $fld->htmlAfterField .= '<a class="refFile--js" title="' . Labels::getLabel('LBL_DOWNLOAD_FILE', $siteLangId) . '" href="' . UrlHelper::generateUrl('SellerRequests', 'downloadFile', array($badgeReqId)) . '">
                                <svg class="svg btn-icon-start" width="18" height="18">
                                <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#download">
                                </use>
                            </svg>
                                </a>';
        $fld->htmlAfterField .= '<a class="refFile--js" title="' . Labels::getLabel('LBL_DELETE_FILE', $siteLangId) . '" href="javascript:void(0);" onclick="removeBadgeRequestRefFile(' . $badgeReqId . ')">
                                <svg class="svg btn-icon-start" width="18" height="18">
                                <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
                                </use>
                            </svg>
                                </a>';
    }
}

?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_REQUEST_TO_BIND_BADGE', $siteLangId) ?></h5>
</div>
<div class="modal-body form-edit">
    <?php if (!empty($approvalRequiredBadges)) { ?>
        <div class="form-edit-body loaderContainerJs">

            <?php echo $frm->getFormHtml(); ?>

        </div>
        <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
    <?php } else { ?>
        <div class="form-edit-body loaderContainerJs">
            <?php echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('LBL_NO_BADGE_FOUND_TO_BIND', $siteLangId)); ?>
        </div>
    <?php }  ?>
</div>
<script>
    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
    var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;
</script>