<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 6;

$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand');

$fld = $frm->getField('breq_message');
if (null != $fld) {
    $fld->developerTags['col'] = 4;
}

$fld = $frm->getField('badgelink_record_id');
if (null != $fld) {
    $fld->developerTags['col'] = 8;
	$fld->htmlAfterField = '<div class="recordsContainer--js p-0 box--scroller"></div>';
}

$fld = $frm->getField('breq_status');
if (null != $fld) {
    $fld->developerTags['col'] = 2;
	$fld->htmlAfterField = '<small class="form-text text-muted">' . Labels::getLabel('LBL_BADGE_REQUEST_REFERENCE_FILE', $adminLangId) . '</small>';
    if (0 < $badgeReqId && true === $fileFound) {
        $fld->htmlAfterField .= '<a class="refFile--js" title="' . Labels::getLabel('LBL_DOWNLOAD_FILE', $adminLangId). '" href="'.UrlHelper::generateUrl('BadgeRequests', 'downloadFile', array($badgeReqId)).'">
                                    <i class="fas fa-download"></i>
                                </a>';
    }
}
?>

<section class="section">
    <div class="sectionhead">
        <h4>
            <?php echo Labels::getLabel('LBL_REQUEST_TO_BIND_BADGE', $adminLangId); ?>
        </h4>
        <div class="section__toolbar col-auto">
            <a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary ">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
</section>

<script>
	var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
	var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
	var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;
</script>