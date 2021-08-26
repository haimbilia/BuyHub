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
    if (0 < $badgeReqId && true === $fileFound) {
        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
        $uploadedTime = AttachedFile::setTimeParam($res['afile_updated_at']);
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php echo $frm->getFormTag(); 
                    echo $frm->getFieldHtml('breq_id');
                    echo $frm->getFieldHtml('record_ids');
                    echo $frm->getFieldHtml('breq_record_type');
                    echo $frm->getFieldHtml('breq_user_id');
                    echo $frm->getFieldHtml('breq_blinkcond_id');
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $msgfld = $frm->getField('breq_message');
                                    echo $msgfld->getCaption();
                                    ?>
                                </label>
                            </div>

                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $msgfld->value; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('badgelink_record_id');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>

                            <div class="field-wraper">
                                <div class="field_cover">
                                    <?php echo $frm->getFieldHtml('badgelink_record_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    echo Labels::getLabel('LBL_BADGE_REQUEST_REFERENCE_FILE', $adminLangId);
                                    ?>
                                </label>
                            </div>

                            <div class="field-wraper">
                                <div class="field_cover">
                                    <div class="badge-request-media">
                                        <a class="refFile--js" title="<?php echo Labels::getLabel('LBL_DOWNLOAD_FILE', $adminLangId) ?>" href=" <?php echo UrlHelper::generateUrl('BadgeRequests', 'downloadFile', array($badgeReqId)) ?>">
                                            <img src=" <?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeRequest', array($badgeReqId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') ?>" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="field-set">
                            <div class="caption-wraper">
                                <label class="field_label">
                                    <?php
                                    $fld = $frm->getField('breq_status');
                                    echo $fld->getCaption();
                                    ?>
                                </label>
                            </div>

                            <div class="field-wraper">
                                <div class="field_cover d-flex">
                                    <?php echo $frm->getFieldHtml('breq_status'); ?>
                                    <?php echo $frm->getFieldHtml('btn_submit'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $frm->getExternalJS(); ?>
                </from>
            </div>
        </div>
    </div>
    </div>
</section>

<script>
    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
    var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;
</script>