<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('onsubmit', 'uploadCollectionImage(this); return(false);');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$fld = $frm->getField('collection_image');
$fld->value= '<label class="label">'.Labels::getLabel('LBL_UPLOAD_BANNER', $siteLangId).'</label><span id="collectionImageHtml"></span>';

$fld->htmlAfterField ='<span class="form-text text-muted">'.sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '610 x 343').'</span>';
?>
<div class="col-md-12">
    <?php echo $frm->getFormHtml(); ?>  
</div>
<script>
    var collectionMediaWidth = '610';
    var collectionMediaHeight = '343';
</script>