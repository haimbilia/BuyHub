<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'setupProfileProduct(this); return(false);');
$proFld = $frm->getField("product_name");
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $siteLangId));
$formTitle = Labels::getLabel('LBL_PROFILE_PRODUCT_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form-head.php');
?>
<div class="form-edit-body loaderContainerJs">
    <div class="alert alert-solid-brand " role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i>
        </div>
        <div class="alert-text text-xs"><?php echo Labels::getLabel("LBL_Product_will_automatically_remove_from_other_profile", $siteLangId); ?></div>
    </div>
    <?php echo $frm->getFormHtml(); ?>
</div>
<?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div> 
