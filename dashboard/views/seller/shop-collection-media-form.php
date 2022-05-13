<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('onsubmit', 'uploadCollectionImage(this); return(false);');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$fld = $frm->getField('collection_image');
$fld->value= '<label class="label">'.Labels::getLabel('LBL_UPLOAD_BANNER', $siteLangId).'</label><span id="collectionImageHtml"></span>';

$fld->htmlAfterField ='<span class="form-text text-muted">'.sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $imageDimension['width'].' x '.$imageDimension['height']).'</span>';

unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SHOP_COLLECTIONS_SETUP'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs" id="shopFormChildBlockTabsJs">
            <a class="nav-link " href="javascript:void(0);" onclick="getShopCollectionGeneralForm(<?php echo $scollection_id; ?>);" title="<?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_GENERAL', $siteLangId); ?>
            </a>
            <?php if(0 < count($languages)){ ?>
            <a class="nav-link" href="javascript:void(0);" onclick="editShopCollectionLangForm(<?php echo $scollection_id ?>,<?php echo array_key_first($languages); ?>)" title="<?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
            </a>
            <?php } ?>
            <a class="nav-link" onclick="sellerCollectionProducts(<?php echo $scollection_id ?>)" href="javascript:void(0);" title="<?php echo Labels::getLabel('LBL_LINK', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_LINK', $siteLangId); ?>
            </a>
            <a class="nav-link active" onclick="collectionMediaForm(<?php echo $scollection_id; ?>)" href="javascript:void(0);" title="<?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
            </a>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs">
        <div class="row" id="shopFormChildBlockJs">
            <div class="col-md-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>    
</div>
<script>
    var collectionMediaWidth = <?php echo $imageDimension['width'];?>;
    var collectionMediaHeight = <?php echo $imageDimension['height'];?>;
</script>