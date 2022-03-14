<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($brandReqMediaFrm);
$brandReqMediaFrm->setFormTagAttribute('class', 'form modalFormJs');
$brandReqMediaFrm->setFormTagAttribute('data-onclear', "brandMediaForm(" . $brandReqId . ");");

$fld = $brandReqMediaFrm->getField('brand_lang_id');
$fld->addFieldTagAttribute('id', 'brandlogoLanguageJs');


$ratioFld = $brandReqMediaFrm->getField('ratio_type');
$ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
$ratioFld->addOptionListTagAttribute('class', 'list-radio');
$ratioFld = HtmlHelper::configureRadioAsButton($brandReqMediaFrm, 'ratio_type');

$fld = $brandReqMediaFrm->getField('logo');
$fld->htmlAfterField = '<small class="form-text text-muted preferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), '500 x 500') . '</small>';

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {   	
	$uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);	
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'brandReal', array($image['afile_record_id'], $image['afile_lang_id'], 'THUMB'), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ]; 
 } 
 $fld->value = '<label class="label">'.Labels::getLabel('FRM_BRAND_LOGO', $siteLangId).'</label>';
 $fld->value.= HtmlHelper::getfileInputHtml(
    ['onChange' => 'brandPopupImage(this)', 'accept' => 'image/*', 'data-name' =>  Labels::getLabel("FRM_BRAND_LOGO", $siteLangId)],
    $siteLangId,
    ('removeBrandLogo(' . $image['afile_record_id'] . "," . $image['afile_lang_id'] .')'),
    ('editDropZoneImages(this)'),   
    $imgArr,
    'dropzone-custom dropzoneContainerJs'
);

echo $brandReqMediaFrm->getFormHtml();
?>
<script>
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    $(document).on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 500'));
        } else {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 280'));
        }
    });
   
</script>