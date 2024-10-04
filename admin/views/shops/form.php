<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', false, "modal-dialog-vertical-md")');

$countryFld = $frm->getField('shop_country_code');
$countryFld->setFieldTagAttribute('id', 'geo_country_code');
$countryFld->setFieldTagAttribute('class', 'addressSelection-js');
$countryFld->setFieldTagAttribute('onChange', 'getStatesByCountryCode(this.value,' . $stateId . ',\'#geo_state_code\', \'state_code\')');

$stateFld = $frm->getField('shop_state');
$stateFld->setFieldTagAttribute('id', 'geo_state_code');
$stateFld->setFieldTagAttribute('class', 'addressSelection-js');

$fld = $frm->getField('shop_featured');
HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel('LBL_FEATURED_SHOPS_WILL_BE_LISTED_ON_FEATURED_SHOPS_PAGE', $siteLangId));
$fld->developerTags['noCaptionTag'] = true;

$urlFld = $frm->getField('urlrewrite_custom');
$urlFld->setFieldTagAttribute('id', "urlrewrite_custom");
$urlFld->htmlAfterField = "<small class='text--small'>" . HtmlHelper::seoFriendlyUrl(UrlHelper::generateFullUrl('shops', 'View', array($recordId), CONF_WEBROOT_FRONT_URL)) . '</small>';
$urlFld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value,$recordId)");

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
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];
$fld = $frm->getField('urlrewrite_custom');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];
$fld = $frm->getField('shop_phone');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('shop_country_code');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('shop_state');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('shop_postalcode');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('shop_cod_min_wallet_balance');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('shop_fulfillment_type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('shop_return_age');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('shop_cancellation_age');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('shop_city');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('shop_contact_person');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];


$fld = $frm->getField('shop_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['colWidthValues'] = [null, '12', null, null];
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('shop_featured');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$generalTab['attr']['onclick'] = 'editRecord(' . $recordId . ', false, "modal-dialog-vertical-md")';
$langTabExtraClass = "modal-dialog-vertical-md";

$formTitle = Labels::getLabel('LBL_SHOP_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) { ?>
    <script>
        $(document).ready(function() {
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            initMap(lat, lng);
        });
    </script>
<?php } ?>