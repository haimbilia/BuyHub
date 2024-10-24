<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'collectionMediaForm(' . $recordId . ',' . $collection_type . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$displayMediaOnlyObj = $frm->getField('collection_display_media_only');
HtmlHelper::configureSwitchForCheckbox($displayMediaOnlyObj);
$displayMediaOnlyObj->developerTags['noCaptionTag'] = true;
$displayMediaOnlyObj->setFieldTagAttribute('class', 'displayMediaOnlyJs');
$displayMediaOnlyObj->setFieldTagAttribute('onclick', 'displayMediaOnly(' . $recordId . ', this)');
if (0 < $displayMediaOnly) {
    $displayMediaOnlyObj->setFieldTagAttribute('checked', 'checked');
}

$str = '<span class="form-text text-muted">' . Labels::getLabel('LBL_IF_USED_FOR_MOBILE_APPLICATIONS', $siteLangId) . '</span>';
$displayMediaOnlyObj->htmlAfterField = $str;

$fld = $frm->getField('collection_image');
$fld->setWrapperAttribute('class', 'mediaElementsJs');
$fld->value = HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_COLLECTION_IMAGE", $siteLangId),
        'data-frm' => $frm->getFormTagAttribute('name')
    ],
    $siteLangId,
    '',
    '',
    [],
    'dropzone-custom dropzoneContainerJs'
);

$htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_PREFERRED_DIMENSIONS', $siteLangId), $imageDimension['width'].'*'.$imageDimension['height']) . '</span>';
$htmlAfterField .= '<div id="imageListingJs"></div>';
$fld->htmlAfterField = $htmlAfterField;

$langFld = $frm->getField('lang_id');
$langFld->setWrapperAttribute('class', 'mediaElementsJs');
$langFld->addFieldTagAttribute('onchange', 'loadImages(' . $recordId . ', this.value);');

$generalTab['attr']['onclick'] = 'collectionForm(' . $collection_type . ', ' . $collection_layout_type . ', ' . $recordId . ');';

if (!in_array($collection_type, Collections::COLLECTION_WITHOUT_RECORDS)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'recordForm(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_LINK_RECORDS', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LINK_RECORDS', $siteLangId),
        'isActive' => false
    ];
}

if ((!in_array($collection_type, Collections::COLLECTION_WITHOUT_MEDIA) && !in_array($collection_layout_type, Collections::COLLECTIONS_FOR_WEB_ONLY))) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'collectionMediaForm(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => true
    ];
}

$includeTabs = ($collection_layout_type != Collections::TYPE_PENDING_REVIEWS1);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>

<script type="text/javascript">
    $('input[name=min_width]').val(<?php echo $imageDimension['width'];?>);
    $('input[name=min_height]').val(<?php echo $imageDimension['height'];?>); 
</script>