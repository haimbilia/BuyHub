<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($shopFrm, 4);
$shopFrm->setFormTagAttribute('onsubmit', 'setupShop(this); return(false);');
$shopFrm->setFormTagAttribute('class', 'form form--horizontal');

$countryFld = $shopFrm->getField('shop_country_code');
$countryFld->setFieldTagAttribute('id', 'shop_country_code');
$countryFld->setFieldTagAttribute('onChange', 'getStatesByCountryCode(this.value,' . $stateId . ',\'#shop_state\', \'state_code\')');
$countryFld->setFieldTagAttribute('class', 'addressSelection-js');
$stateFld = $shopFrm->getField('shop_state');
$stateFld->setFieldTagAttribute('id', 'shop_state');
$stateFld->setFieldTagAttribute('class', 'addressSelection-js');
$urlFld = $shopFrm->getField('urlrewrite_custom');
$urlFld->setFieldTagAttribute('id', "urlrewrite_custom");
$urlFld->setFieldTagAttribute('onkeyup', "getUniqueSlugUrl(this,this.value,$shop_id)");
$urlFld->htmlAfterField = "<p class='note' id='shopurl'>" . UrlHelper::generateFullUrl('Shops', 'View', array($shop_id), '/') . '</p>';
$IDFld = $shopFrm->getField('shop_id');
$IDFld->setFieldTagAttribute('id', "shop_id");
$identiFierFld = $shopFrm->getField('shop_identifier');
$identiFierFld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','shop_id','shopurl')");
$variables = array('language' => $language, 'siteLangId' => $siteLangId, 'shop_id' => $shop_id, 'action' => $action);
$postalCode = $shopFrm->getField('shop_postalcode');
$postalCode->setFieldTagAttribute('id', "postal_code");

$latFld = $shopFrm->getField('shop_lat');
$latFld->setFieldTagAttribute('id', "lat");
$lngFld = $shopFrm->getField('shop_lng');
$lngFld->setFieldTagAttribute('id', "lng");

$fld = $shopFrm->getField('shop_pickup_interval');
$fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('LBL_SHOP_PICKUP_INTERVAL_INFO', $siteLangId) . ' </span>';

$btnSubmit = $shopFrm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand btn-wide");

$fld = $shopFrm->getField('shop_invoice_codes');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];
$fld->addFieldTagAttribute('maxlength', Shop::GOVT_INFO_LEN);
?>
<div class="card-body ">
    <?php echo $shopFrm->getFormHtml(); ?> 
    <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)  && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))  ) { ?>
        <div class="g-map" id="map" style="height:500px"></div>
    <?php } ?>
</div>
<?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '')) ) { ?>
    <script>
        var lat = (!$('#lat').val()) ? 0 : $('#lat').val();
        var lng = (!$('#lng').val()) ? 0 : $('#lng').val();
        $.getScript( "https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''); ?>", function( data, textStatus, jqxhr ) {
            initMap(lat, lng);          
        });      
    </script>
<?php } ?>