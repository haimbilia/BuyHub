<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('onsubmit', 'setupProfileProduct(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'profileProductForm(' . $profile_id . ')');

$proFld = $frm->getField("shippro_product_id");
$proFld->addFieldTagAttribute('id', 'ShippingProfProductJs');
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $siteLangId));

$formTitle = Labels::getLabel('LBL_PROFILE_PRODUCT_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    $(document).ready(function() {
        select2('ShippingProfProductJs', fcom.makeUrl('shippingProfileProducts', 'autoComplete'), {
            shipProfileId : $('input[name="shippro_shipprofile_id"]').val()
        });
    });
</script>