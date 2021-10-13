<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);

$tbid = isset($tabId) ? $tabId : 'tabs_' . $frmType;

if ($lang_id > 0) {
    $frm->setFormTagAttribute('onsubmit', 'setupLang(this); return(false);');
    $langFld = $frm->getField('lang_id');
    $langFld->setfieldTagAttribute('onChange', "getLangForm(" . $frmType . ", this.value);");
} else {
    $frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
}

$stateData = FatApp::getConfig('CONF_STATE', FatUtility::VAR_INT, 1);
$displayMap = false;
switch ($frmType) {
    case Configurations::FORM_PRODUCT:
        $geoFld = $frm->getField('CONF_PRODUCT_GEO_LOCATION');
        $geoFld->setFieldTagAttribute('class', 'geoLocation');

        $lFld = $frm->getField('CONF_LOCATION_LEVEL');
        $lFld->setFieldTagAttribute('class', 'listingFilter');
        if (FatApp::getConfig('CONF_PRODUCT_GEO_LOCATION', FatUtility::VAR_INT, 0) != applicationConstants::BASED_ON_RADIUS) {
            $rFld = $frm->getField('CONF_RADIUS_DISTANCE_IN_MILES');
            $rFld->setFieldTagAttribute('disabled', 'disabled');
        }

        if (FatApp::getConfig('CONF_PRODUCT_GEO_LOCATION', FatUtility::VAR_INT, 0) == applicationConstants::BASED_ON_RADIUS) {
            $lFld->setFieldTagAttribute('disabled', 'disabled');
        }

        $fld = $frm->getField('CONF_DEFAULT_GEO_LOCATION');
        $fld->setFieldTagAttribute('class', 'defaultLocationGeoFilter');

        $countryFld = $frm->getField('CONF_GEO_DEFAULT_COUNTRY');
        $stateFld = $frm->getField('CONF_GEO_DEFAULT_STATE');

        if ($countryFld) {
            $countryFld->setFieldTagAttribute('id', 'geo_country_code');
            $countryFld->setFieldTagAttribute('onChange', 'getStatesByCountryCode(this.value,' . FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_STRING, 1) . ',\'#geo_state_code\', \'state_code\')');

            $stateFld->setFieldTagAttribute('id', 'geo_state_code');
        }
        $stateData = FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_INT, 1);

        $zipFld = $frm->getField('CONF_GEO_DEFAULT_ZIPCODE');
        $zipFld->setFieldTagAttribute('id', 'geo_postal_code');

        if (FatApp::getConfig('CONF_DEFAULT_GEO_LOCATION', FatUtility::VAR_INT, 0) != applicationConstants::YES) {
            $countryFld->setFieldTagAttribute('disabled', 'disabled');
            $stateFld->setFieldTagAttribute('disabled', 'disabled');
            $zipFld->setFieldTagAttribute('disabled', 'disabled');
        }

        $latFld = $frm->getField('CONF_GEO_DEFAULT_LAT');
        $latFld->setFieldTagAttribute('id', "lat");
        $lngFld = $frm->getField('CONF_GEO_DEFAULT_LNG');
        $lngFld->setFieldTagAttribute('id', "lng");
        $lngFld = $frm->getField('CONF_GEO_DEFAULT_ADDR');
        $lngFld->setFieldTagAttribute('id', "geo_city");

        $displayMap = true;
        break;
    case Configurations::FORM_LOCAL:
        $countryFld = $frm->getField('CONF_COUNTRY');
        if ($countryFld) {
            $countryFld->setFieldTagAttribute('id', 'user_country_id');
            $countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . FatApp::getConfig('CONF_STATE', FatUtility::VAR_INT, 1) . ',\'#user_state_id\')');

            $stateFld = $frm->getField('CONF_STATE');
            $stateFld->setFieldTagAttribute('id', 'user_state_id');
        }
        break;
}
?>
<div class="card-body">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php if ($dispLangTab) { ?>
                <div class="form-edit-head">
                    <nav class="nav nav-tabs">
                        <?php if ($frmType != Configurations::FORM_MEDIA && $frmType != Configurations::FORM_SHARING) { ?>
                            <a class="nav-link <?php echo ($lang_id == 0) ? 'active' : ''; ?>" href="javascript:void(0)" onClick="getForm(<?php echo $frmType; ?>)">
                                <?php echo Labels::getLabel('LBL_Basic', $adminLangId); ?>
                            </a>
                        <?php } ?>

                        <a class="nav-link <?php echo (0 < $lang_id ? 'active' : '') ?>" href="javascript:void(0);" onClick="getLangForm(<?php echo $frmType; ?>, <?php echo FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1); ?>)">
                            <?php echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
                        </a>
                    </nav>
                </div>
            <?php } ?>
            <div class="form-edit-body formBodyJs">
                <?php echo $frm->getFormHtml(); ?>
                <?php if ($displayMap && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
                    <div id="map" style="width:900px; height:500px"></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="card-foot">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col">
                    <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_UPDATE', $adminLangId), 'button'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script language="javascript">
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    <?php if ($displayMap && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
        getStatesByCountryCode($("#geo_country_code").val(), '<?php echo FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_STRING, 1); ?>', '#geo_state_code', 'state_code');
    <?php } ?>

    $(document).on('change', '.prefRatio-js', function() {
        var inputElement = $(this).parents('.list-inline').next('input');
        var selectedVal = $(this).val();
        if (selectedVal == ratioTypeSquare) {
            inputElement.attr('data-min_width', 150)
            inputElement.attr('data-min_height', 150)
        } else {
            inputElement.attr('data-min_width', 150)
            inputElement.attr('data-min_height', 85)
        }
    });

    $(document).on('change', '.geoLocation', function() {
        var geolocVal = $(this).val();

        $('.listingFilter').removeAttr('disabled');
        if (geolocVal == <?php echo applicationConstants::BASED_ON_RADIUS; ?>) {
            $('.listingFilter').attr('disabled', 'disabled');
            $('input[name="CONF_RADIUS_DISTANCE_IN_MILES"]').prop('disabled', false); // enable
        } else {
            $('input[name="CONF_RADIUS_DISTANCE_IN_MILES"]').prop('disabled', true); // enable
        }

        if (geolocVal == <?php echo applicationConstants::BASED_ON_DELIVERY_LOCATION; ?>) {
            $('.listingFilter').each(function() {
                if ($(this).val() == <?php echo applicationConstants::LOCATION_ZIP; ?>) {
                    $(this).attr('disabled', 'disabled');
                }
            });
        }
    });

    $(document).on('change', '.defaultLocationGeoFilter', function() {
        if ($(this).val() == 1) {
            $('select[name="CONF_GEO_DEFAULT_COUNTRY"]').prop('disabled', false); // enable
            $('select[name="CONF_GEO_DEFAULT_STATE"]').prop('disabled', false); // enable
            $('input[name="CONF_GEO_DEFAULT_ZIPCODE"]').prop('disabled', false); // enable
        } else {
            $('select[name="CONF_GEO_DEFAULT_COUNTRY"]').prop('disabled', true); // enable
            $('select[name="CONF_GEO_DEFAULT_STATE"]').prop('disabled', true); // enable
            $('input[name="CONF_GEO_DEFAULT_ZIPCODE"]').prop('disabled', true); // enable
        }
    });
    <?php if ($displayMap && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
        $(document).ready(function() {
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            initMap(lat, lng);
        });
    <?php } else { ?>
        var countryId = $("#user_country_id").val();
        if ('undefined' != typeof countryId) {
            getCountryStates(countryId, '<?php echo $stateData; ?>', '#user_state_id');
        }
    <?php } ?>
    $(document).on('keyup', 'form[name="frmConfiguration"]', function(e) {
        e.stopImmediatePropagation();
        if (e.keyCode === 13) {
            $('.formBodyJs form').submit();
        }
    });
</script>