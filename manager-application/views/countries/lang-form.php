<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$langFrm->setCustomRendererClass('FormRendererBS');

/* For Each Row On Above Elements */
$langFrm->developerTags['colWidthClassesDefault'] = ['col-md-', null, null];
$langFrm->developerTags['colWidthValuesDefault'] = [12, null, null];
/* For Each Row On Above Elements */

/* For Input Fields */
$langFrm->developerTags['fldWidthClassesDefault'] = ['', '', '', ''];
$langFrm->developerTags['fldWidthValuesDefault'] = ['', '', '', ''];
/* For Input Fields */

/* For Labels Fields */
$langFrm->developerTags['labelWidthClassesDefault'] = ['label', 'label', 'label', 'label'];
$langFrm->developerTags['labelWidthValuesDefault'] = ['', '', '', ''];
/* For Labels Fields */

/* Group Label and Input field. */
$langFrm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
/* Group Label and Input field. */

$langFrm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData(this); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editLangData(" . $countryId . ", this.value);");
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COUNTRY_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link" href="javascript:void(0)" onclick="editRecord(<?php echo $countryId ?>);">
                <?php echo Labels::getLabel('LBL_GENERAL', $adminLangId); ?>
            </a>
            <a class="nav-link active" href="javascript:void(0);" <?php echo (0 < $countryId) ? "onclick='editLangData(" . $countryId . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $adminLangId); ?>
            </a>
        </nav>
    </div>

    <div class="form-edit-body loaderContainerJs">
        <?php
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        if (!empty($translatorSubscriptionKey) && $lang_id != $siteDefaultLangId) { ?> 
            <div class="row justify-content-end"> 
                <div class="col-auto mb-4">
                    <input class="btn btn-brand" 
                        type="button" 
                        value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $adminLangId); ?>" 
                        onClick="editLangData(<?php echo $countryId; ?>, <?php echo $lang_id; ?>, 1)">
                </div>
            </div>
        <?php } ?>
        <?php echo $langFrm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php echo Labels::getLabel('LBL_UPDATE', $adminLangId); ?>
                </button>
            </div>
        </div>
    </div>
</div>