<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="generalForm"></div>
<?php
$frm->setFormTagAttribute('class', 'web_form form_horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupShop(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$countryFld = $frm->getField('shop_country_code');
$countryFld->setFieldTagAttribute('id', 'geo_country_code');
$countryFld->setFieldTagAttribute('class', 'addressSelection-js');
$countryFld->setFieldTagAttribute('onChange', 'getStatesByCountryCode(this.value,' . $stateId . ',\'#geo_state_code\', \'state_code\')');

$stateFld = $frm->getField('shop_state');
$stateFld->setFieldTagAttribute('id', 'geo_state_code');
$stateFld->setFieldTagAttribute('class', 'addressSelection-js');

$fld = $frm->getField('shop_featured');
$fld->htmlAfterField = '<small><br>' . Labels::getLabel('LBL_Featured_Shops_will_be_listed_on_Featured_Shops_Page._Featured_Shops_will_get_priority,', $siteLangId) . '</small>';
$urlFld = $frm->getField('urlrewrite_custom');
$urlFld->setFieldTagAttribute('id', "urlrewrite_custom");
$urlFld->htmlAfterField = "<small class='text--small'>" . UrlHelper::generateFullUrl('shops', 'View', array($shop_id), CONF_WEBROOT_FRONT_URL) . '</small>';
$urlFld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value,$shop_id)");

$postalCode = $frm->getField('shop_postalcode');
$postalCode->setFieldTagAttribute('id', "geo_postal_code");

$latFld = $frm->getField('shop_lat');
$latFld->setFieldTagAttribute('id', "lat");
$lngFld = $frm->getField('shop_lng');
$lngFld->setFieldTagAttribute('id', "lng");

$otherButtons = [
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $shop_id . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];
$formTitle = Labels::getLabel('LBL_SHOP_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) { ?>
    <script>
        $(document).ready(function () {
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            initMap(lat, lng);
        });
    </script>
<?php } ?>