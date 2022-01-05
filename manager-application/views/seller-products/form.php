<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$fld = $frm->getField('use_shop_policy');
$fld->setFieldTagAttribute('class', "fieldsVisibilityJs");


$fld = $frm->getField('selprod_threshold_stock_level');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

HtmlHelper::addFieldLabelInfo($frm,'selprod_threshold_stock_level',Labels::getLabel('MSG_ALERT_STOCK_LEVEL_HINT_INFO', $siteLangId),['id'=>'selprod_threshold_stock_level']);


$fld = $frm->getField('selprod_cost');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('selprod_price');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('selprod_stock');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('selprod_sku');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('selprod_available_from');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('selprod_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('selprod_min_order_qty');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('selprod_fulfillment_type');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('selprod_return_age');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('selprod_cancellation_age');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('selprod_max_download_times');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('selprod_download_validity_in_days');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('selprod_condition');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('use_shop_policy');
HtmlHelper::configureSwitchForCheckbox($fld);
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$fld = $frm->getField('selprod_cod_enabled');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
    $fld->setWrapperAttribute('class', 'selprod_cod_enabled_fld');
}

$fld = $frm->getField('selprod_fulfillment_type');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('selprod_subtract_stock');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['colWidthValues'] = [null, '12', null, null];
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('selprod_track_inventory');
HtmlHelper::configureSwitchForCheckbox($fld);
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
    $fld->addFieldtagAttribute('onchange', 'trackInventory(this)');
    $fld->addFieldtagAttribute('id', 'selprod_track_inventory');    
}
$formTitle = Labels::getLabel('LBL_SELLER_INVENTORY_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>

<script type="text/javascript"> 
    $("document").ready(function() {  
        <?php if($shippedBySeller == 0){?>
            $(".selprod_cod_enabled_fld").hide();    
        <?php }?>
        $("#selprod_track_inventory").trigger('change');       
    });
</script>
