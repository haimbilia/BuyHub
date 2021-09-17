<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setCustomRendererClass('FormRendererBS');

/* For Each Row On Above Elements */
$frm->developerTags['colWidthClassesDefault'] = ['col-md-', null, null];
$frm->developerTags['colWidthValuesDefault'] = [12, null, null];
/* For Each Row On Above Elements */

/* For Input Fields */
$frm->developerTags['fldWidthClassesDefault'] = ['', '', '', ''];
$frm->developerTags['fldWidthValuesDefault'] = ['', '', '', ''];
/* For Input Fields */

/* For Labels Fields */
$frm->developerTags['labelWidthClassesDefault'] = ['label', 'label', 'label', 'label'];
$frm->developerTags['labelWidthValuesDefault'] = ['', '', '', ''];
/* For Labels Fields */

/* Group Label and Input field. */
$frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
/* Group Label and Input field. */

$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'setupCountry(this); return(false);'); 

$btn = $frm->getField('btn_submit');
$btn->setFieldTagAttribute('class', 'btn btn-brand gb-btn gb-btn-primary');
$btn->developerTags['colWidthValues'] = ['form-edit-foot', null, null];
$btn->developerTags['fldWidthValues'] = ['col-auto', '', '', ''];
$btn->developerTags['noCaptionTag'] = true;
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COUNTRY_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body">
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link active" href="javascript:void(0)" onclick="editCountryForm(<?php echo $country_id ?>);">
                <?php echo Labels::getLabel('LBL_General', $adminLangId); ?>
            </a>
            <a class="nav-link" href="javascript:void(0);" <?php echo (0 < $country_id) ? "onclick='editCountryLangForm(" . $country_id . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
            </a>
        </nav>
    </div>

    <div class="form-edit-body">
        <?php echo $frm->getFormHtml(); ?>
    </div>
</div>