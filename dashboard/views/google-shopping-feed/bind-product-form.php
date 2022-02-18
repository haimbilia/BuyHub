<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('id', 'bindProducts');
$frm->setFormTagAttribute('onsubmit', 'setupProductsToBatch(this); return(false);');
$frm->setFormTagAttribute('data-onclear', "bindproductform(" . $adsBatchId . ", " . $selProdId . ")"); 

$fld = $frm->getField('abprod_selprod_id');
$fld->setFieldTagAttribute('class', 'sellerProductJs');
if (0 < $selProdId) {
    $fld->setFieldTagAttribute('disabled', 'disabled');
}

$fld = $frm->getField('abprod_cat_id');
$fld->setFieldTagAttribute('id', 'googleCatIdJs')
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_BIND_PRODUCT', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>