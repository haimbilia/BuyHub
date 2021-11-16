<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($cbgForm);
$cbgForm->setFormTagAttribute('class', 'modal-body form');

$fld = $cbgForm->getField('cpage_bg_image');
$fld->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '1300 x 400') . '</span>';
$fld->value = '<span id="imageListingJs"></span>';

$imageLangFld = $cbgForm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => true
    ]
];

$formTitle = Labels::getLabel('LBL_CONTENT_PAGE_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $cbgForm->getFormHtml(); ?>
    </div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->