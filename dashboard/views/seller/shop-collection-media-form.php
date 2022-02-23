<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('onsubmit', 'uploadCollectionImage(this); return(false);');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$fld = $frm->getField('collection_image');
$fld->addFieldTagAttribute('class', '');
$fld->addFieldTagAttribute('onChange', 'collectionPopupImage(this)');
?>
<div class="col-md-12">
    <small class="form-text text-muted"><?php echo sprintf(Labels::getLabel('MSG_Upload_shop_collection_image_text', $siteLangId), '610*343') ?></small>
    <?php echo $frm->getFormHtml(); ?>
    <div id="imageListing"></div>
</div>
<script>
    var collectionMediaWidth = '610';
    var collectionMediaHeight = '343';
</script>