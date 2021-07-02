<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupBadgeReq(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 6;

$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand');
$submitFld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('badgelink_record_id');
if (null != $fld) {
    $fld->developerTags['col'] = 8;
    $fld->htmlAfterField = '<div class="recordsContainer--js p-0 box--scroller"></div>';
}

$fld = $frm->getField('breq_blinkcond_id');
if (null != $fld && 0 < $blinkCondId) {
    $fld->setFieldTagAttribute('data-oldvalue', $blinkCondId);
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
                                    <i class="fas fa-download"></i>
                                </a>';
        $fld->htmlAfterField .= '<a class="refFile--js" title="' . Labels::getLabel('LBL_DELETE_FILE', $siteLangId) . '" href="javascript:void(0);" onclick="removeBadgeRequestRefFile(' . $badgeReqId . ')">
                                    <i class="fas fa-times"></i>
                                </a>';
    }
}

$fld = $frm->getField('breq_blinkcond_id');
if (null != $fld) {
    $fld->addFieldTagAttribute('onchange', 'getRecordType(this)');
}

?>
<div class="card-body">
    <div class="box__head row">
        <h4 class="col"><?php echo Labels::getLabel('LBL_REQUEST_TO_BIND_BADGE', $siteLangId); ?></h4>
        <div class="section__toolbar col-auto">
            <a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary ">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
    <div class="box__body">
        <div class="row">
            <div class="col-md-12">
                <div class="form__subcontent">
                    <?php echo $frm->getFormHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
    var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;
</script>