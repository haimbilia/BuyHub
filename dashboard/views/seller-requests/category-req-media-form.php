<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "categoryReqMediaForm(" . $recordId . ");");

$fld = $frm->getField('lang_id');
$fld->addFieldTagAttribute('id', 'catLanguageJs');

$minWFld = $frm->getField('min_width');
$minHFld = $frm->getField('min_height');

$fld = $frm->getField('cat_icon');
$fld->htmlAfterField = '<small class="form-text text-muted preferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), $minWFld->value .' x '. $minHFld->value) . '</small>';

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('category', 'icon', array($image['afile_record_id'], $image['afile_lang_id'], ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ];
}
$fld->value = '<label class="label">' . Labels::getLabel('FRM_CATEGORY_LOGO', $siteLangId) . '</label>';
$fld->value .= HtmlHelper::getfileInputHtml(
    ['onChange' => 'categoryPopupImage(this)', 'accept' => 'image/*', 'data-name' =>  Labels::getLabel("FRM_CATEGORY_LOGO", $siteLangId)],
    $siteLangId,
    ('removeCategoryLogo(' . $image['afile_record_id'] . "," . $image['afile_lang_id'] . ')'),
    ('editDropZoneImages(this)'),
    $imgArr,
    'dropzone-custom dropzoneContainerJs'
); 
unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo (FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) ? Labels::getLabel('LBL_Request_New_Category', $siteLangId) : Labels::getLabel('LBL_New_Category', $siteLangId) ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
    <?php if(0 < count($languages)){ ?>
        <nav class="nav nav-tabs navTabsJs">
            <a class="nav-link" href="javascript:void(0);" onclick="addCategoryReqForm(<?php echo $categoryReqId; ?>);">
                <?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
            </a>        
            <a class="nav-link" href="javascript:void(0);" <?php echo (0 < $recordId) ? "onclick='addCategoryReqLangForm(" . $recordId . "," . array_key_first($languages) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
            </a>  
            <a class="nav-link active" href="javascript:void(0);" <?php if ($recordId > 0) { ?> onclick="categoryReqMediaForm(<?php echo $recordId ?>);" <?php } ?>>
            <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
        </a>
        </nav>
        <?php } ?>
    </div>
    <div class="form-edit-body loaderContainerJs" id="categoryReqFormJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>