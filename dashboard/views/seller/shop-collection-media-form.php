<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frm->setFormTagAttribute('onsubmit', 'uploadCollectionImage(this); return(false);');
    $frm->setFormTagAttribute('class', 'form');
    $frm->developerTags['colClassPrefix'] = 'col-md-';
    $frm->developerTags['fld_default_col'] = 6;

    $fld = $frm->getField('collection_image');
    $fld->addFieldTagAttribute('class', '');
    $fld->addFieldTagAttribute('onChange', 'collectionPopupImage(this)');
?>
<div class="col-md-12">
    <small class="form-text text-muted"><?php echo sprintf(Labels::getLabel('MSG_Upload_shop_collection_image_text', $siteLangId), '610*343')?></small>
    <?php echo $frm->getFormHtml();?>
    <div id="imageListing">
        
    </div>
</div>
<script>
    var collectionMediaWidth = '610';
    var collectionMediaHeight = '343';
</script>
