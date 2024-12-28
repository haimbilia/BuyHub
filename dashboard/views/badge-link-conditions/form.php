<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form badgeLinkCondtionJs');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');

$fld = $frm->getField('auto_update_other_langs_data');
if (null != $fld) {
    $fld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
    $fld->developerTags['cbHtmlAfterCheckbox'] = '';
}

$fld = $frm->getField('blinkcond_from_date');
if (null != $fld) {
    $fld->addFieldTagAttribute('class', 'field--calender');
}

$fld = $frm->getField('blinkcond_to_date');
if (null != $fld) {
    $fld->addFieldTagAttribute('class', 'field--calender');
}

$fld = $frm->getField('record_condition');
if (null != $fld) {
    $fld->addFieldTagAttribute('class', 'recCond--js');
}

$fld = $frm->getField('btn_submit');
if (null != $fld) {
    $fld->addFieldTagAttribute('class', 'btn btn-brand btn-block');
}

$fld = $frm->getField('btn_clear');
if (null != $fld) {
    $fld->addFieldTagAttribute('class', 'btn btn-outline-gray btn-block');
    $fld->addFieldTagAttribute('onclick', 'clearForm();');
}

$badgeName = $badgeData['badge_name'];
if (Badge::TYPE_BADGE == $badgeType) {
    $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $badgeId, 0, $siteLangId);
    $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
    $imageHtml = '<img src="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], ImageDimension::VIEW_THUMB, $icon['afile_screen']), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '" title="' . $badgeName . '" alt="' . $badgeName . '">';
} else {
    $badgeData['blinkcond_position'] = Badge::RIBB_POS_TRIGHT;
    $imageHtml = $this->includeTemplate('_partial/ribbon-ui.php', ['ribbRow' => $badgeData], false, true);
}

?>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-lg-4 badgeImageSection--js">
                        <?php if (Badge::TYPE_BADGE == $badgeType) { ?>
                            <div class="badge-image">
                                <?php echo $imageHtml; ?>
                            </div>
                        <?php } else { ?>
                            <div class="products">
                                <div class="products-body">
                                    <div class="badges-wrap">
                                        <?php echo $imageHtml; ?>
                                    </div>
                                    <div class="products-img"> <img
                                            src="<?php echo CONF_WEBROOT_FRONTEND; ?>images/defaults/product_default_image.jpg">
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                    <div class="col-lg-8">
                        <?php echo $frm->getFormTag();
                        echo $frm->getFieldHtml('blinkcond_id');
                        echo $frm->getFieldHtml('blinkcond_badge_id');
                        echo $frm->getFieldHtml('record_ids');
                        echo $frm->getFieldHtml('badge_type');
                        echo $frm->getFieldHtml('record_condition');

                        if (0 < $blinkcond_id) {
                            echo $frm->getFieldHtml('blinkcond_record_type');
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="field-set">
                                    <div class="caption-wraper">
                                        <label class="field_label">
                                            <?php
                                            $fld = $frm->getField('blinkcond_from_date');
                                            echo $fld->getCaption();
                                            ?>
                                        </label>
                                    </div>
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <?php echo $frm->getFieldHtml('blinkcond_from_date'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-set">
                                    <div class="caption-wraper">
                                        <label class="field_label">
                                            <?php
                                            $fld = $frm->getField('blinkcond_to_date');
                                            echo $fld->getCaption();
                                            ?>
                                        </label>
                                    </div>
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <?php echo $frm->getFieldHtml('blinkcond_to_date'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row linkType--js">
                            <?php if (1 > $blinkcond_id) { ?>
                                <div class="col-md-4">
                                    <div class="field-set">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                                <?php
                                                $fld = $frm->getField('blinkcond_record_type');
                                                echo $fld->getCaption();
                                                ?>
                                            </label>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $frm->getFieldHtml('blinkcond_record_type'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType || 1 > $recordType) { ?>
                                <div class="col-md-<?php echo (1 > $blinkcond_id) ? '8' : '12'; ?>">
                                    <div class="field-set">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                                <?php
                                                $fld = $frm->getField('badgelink_record_ids[]');
                                                $fld->addFieldTagAttribute('id', 'recordIds--js');
                                                $fld->addFieldTagAttribute('multiple', true);
                                                echo $fld->getCaption();
                                                ?>
                                            </label>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $fld->getHtml(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (Badge::TYPE_BADGE == $badgeType) { ?>
                            <div class="row conditionType--js">
                                <div class="col-md-4">
                                    <div class="field-set">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                                <?php
                                                $fld = $frm->getField('blinkcond_condition_type');
                                                echo $fld->getCaption();
                                                ?>
                                                <span class="spn_must_field">*</span></label>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $frm->getFieldHtml('blinkcond_condition_type'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="field-set">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                                <?php
                                                $fld = $frm->getField('blinkcond_condition_from');
                                                echo $fld->getCaption();
                                                ?>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $frm->getFieldHtml('blinkcond_condition_from'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="field-set">
                                        <div class="caption-wraper">
                                            <label class="field_label">
                                                <?php
                                                $fld = $frm->getField('blinkcond_condition_to');
                                                echo $fld->getCaption();
                                                ?>
                                        </div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $frm->getFieldHtml('blinkcond_condition_to'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="field-set">
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <?php echo $frm->getFieldHtml('btn_submit'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <?php echo $frm->getExternalJS(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>