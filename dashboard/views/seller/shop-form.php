<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$shopFrm->setFormTagAttribute('onsubmit', 'setupShop(this); return(false);');
$shopFrm->setFormTagAttribute('class', 'form form--horizontal');

$shopFrm->developerTags['colClassPrefix'] = 'col-lg-4 col-md-';
$shopFrm->developerTags['fld_default_col'] = 4;

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
/* $btnSubmit->developerTags['noCaptionTag'] = true; */
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand btn-wide");
?>
<div class="card-body "> 
    <?php echo $shopFrm->getFormHtml(); ?>
    <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) { ?>
        <div class="g-map" id="map"></div>
    <?php } ?>
</div>
<?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) { ?>
    <script>
        var lat = (!$('#lat').val()) ? 0 : $('#lat').val();
        var lng = (!$('#lng').val()) ? 0 : $('#lng').val();
        initMap(lat, lng);
    </script>
<?php } ?>