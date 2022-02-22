<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($settingFrm);

$settingFrm->setFormTagAttribute('data-onclear', "setupSettings(this);return(false);");
$settingFrm->setFormTagAttribute('data-action', "uploadLogo");
$settingFrm->setFormTagAttribute('id', 'frmLangJs');
$settingFrm->setFormTagAttribute('onsubmit', 'setupSettings($("#frmLangJs")); return(false);');
$settingFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$settingFrm->setFormTagAttribute('dir', $formLayout);

$ratioFld = $settingFrm->getField('CONF_EMAIL_TEMPLATE_LOGO_RATIO');
$ratioFld->addOptionListTagAttribute('class', 'list-radio');
$ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
$ratioFld = HtmlHelper::configureRadioAsButton($settingFrm, 'CONF_EMAIL_TEMPLATE_LOGO_RATIO');
$ratioFld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $settingFrm->getField('CONF_EMAIL_TEMPLATE_COLOR_CODE' . $lang_id);
$fld->overrideFldType('color');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$langFld = $settingFrm->getField('lang_id');
if (null != $langFld) {
    if (!$langFld->getfieldTagAttribute('onChange')) {
        $langFld->setfieldTagAttribute('onChange', "editSettingsForm(this.value);");
    }
    $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    if (!empty($translatorSubscriptionKey) && $lang_id != CommonHelper::getDefaultFormLangId()) {
        $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
        $langFld->htmlAfterField = '<a href="javascript:void(0);" onclick="editSettingsForm(' . $lang_id . ', 1)" class="btn" title="' .  Labels::getLabel('BTN_AUTOFILL_LANGUAGE_DATA', $lang_id) . '">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                </use>
                            </svg>
                        </a>';
    }
}

$fld = $settingFrm->getField('CONF_EMAIL_TEMPLATE_FOOTER_HTML' . $lang_id);
$htmlFld = $settingFrm->addHTML('', 'epage_content_html', '<div class="col-md-12"><div class="form-group"><label class="label lbl-link">' . $fld->getCaption() . '<a class="link" href="javascript:void(0)" onclick="resetToDefaultContent();">' . Labels::getLabel('LBL_RESET_TO_DEFAULT_CONTENT', $lang_id) . '</a></label>' . $fld->getHtml() . '</div></div>');
$settingFrm->changeFieldPosition($htmlFld->getFormIndex(), $fld->getFormIndex());
$settingFrm->removeField($fld);

$fld = $settingFrm->getField('auto_update_other_langs_data');
if ($fld != null) {    
    if(!isset($fld->developerTags['colWidthValues'])){
        $fld->developerTags['colWidthValues'] = [null, '12', null, null];
    }
    HtmlHelper::configureSwitchForCheckbox($fld);
}

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Image',
                'emailLogo',
                array(
                    $image['afile_lang_id'],
                    "THUMB"
                ),
                CONF_WEBROOT_FRONT_URL
            ) . $uploadedTime,
            CONF_IMG_CACHE_TIME,
            '.jpg'
        ),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ];
}

$settingFrm->addFormTagAttribute('data-callbackfn', 'logoFormCallback');

$fld = $settingFrm->getField('email_logo');
$fld->value = '<label class="label">' . Labels::getLabel('LBL_ICON', $lang_id) . '</label>' . HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_EMAIL_LOGO", $lang_id)],
    $lang_id,
    ($canEdit ? 'removeEmailLogo(' . $lang_id . ')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);


?>
<div id="editor_default_content" style="display:none;">
    <?php $this->includeTemplate('_partial/emails/email-footer.php', array('langId' => $lang_id, 'defaultContent' => true)); ?>
</div>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_EMAIL_TEMPLATE_SETUP', $lang_id); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $settingFrm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<script>
    $('input[name=logo_min_width]').val(150);
    $('input[name=logo_min_height]').val(150);
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var aspectRatio = 16 / 9;
    $(document).on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $('input[name=logo_min_width]').val(150);
            $('input[name=logo_min_height]').val(150);
        } else {
            $('input[name=logo_min_width]').val(150);
            $('input[name=logo_min_height]').val(85);
        }
    });
</script>