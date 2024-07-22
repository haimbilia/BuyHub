<?php
$geoAddress = '';
if ((!isset($_COOKIE['_ykGeoLat']) || !isset($_COOKIE['_ykGeoLng']) || !isset($_COOKIE['_ykGeoCountryCode'])) && FatApp::getConfig('CONF_DEFAULT_GEO_LOCATION', FatUtility::VAR_INT, 0)) {
    $geoAddress = FatApp::getConfig('CONF_GEO_DEFAULT_ADDR', FatUtility::VAR_STRING, '');
    if (empty($address)) {
        $address = FatApp::getConfig('CONF_GEO_DEFAULT_ZIPCODE', FatUtility::VAR_INT, 0) . '-' . FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_STRING, '');
    }
}
if (empty($geoAddress)) {
    $geoAddress = Labels::getLabel("LBL_Location", $siteLangId);
}
$geoAddress =  isset($_COOKIE["_ykGeoAddress"]) ? $_COOKIE["_ykGeoAddress"] : $geoAddress; ?>
<div class="modal-header">
    <h5 class="modal-title">       
        <?php echo Labels::getLabel("LBL_LOCATION", $siteLangId); ?>
    </h5>
</div>
<div class="modal-body">
<div class="geo-location_body">
    <?php $value = ($geoAddress == Labels::getLabel("LBL_LOCATION", $siteLangId)) ? "" : $geoAddress; ?>
    <input autocomplete="no" id="ga-autoComplete-header" class="geo-location_input pac-target-input" title="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" placeholder="<?php echo Labels::getLabel('LBL_TYPE_YOUR_ADDRESS', $siteLangId); ?>" type="search" name="location" value="<?php echo $value; ?>">

    <button onclick="loadGeoLocation()" class="btn btn-outline-gray btn-block btn-detect">
        <svg class="svg" width="18" height="18">
            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#gps">
            </use>
        </svg>
        <span class="txt">
            <?php echo Labels::getLabel('LBL_DETECT_MY_CURRENT_LOCATION', $siteLangId); ?>
        </span>
    </button>

</div>
</div>
