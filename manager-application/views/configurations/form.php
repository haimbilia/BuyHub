<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$clearFormFn = isset($clearFormFn) ? $clearFormFn : 'getForm(' . $frmType . ')';

HtmlHelper::formatFormFields($frm);
$frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
$frm->setFormTagAttribute('class', 'form form--settings modalFormJs checkboxSwitchJs layout--' . $formLayout);
$frm->setFormTagAttribute('data-onclear', $clearFormFn);
$frm->setFormTagAttribute('id', 'frmConfSetting');

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
$colMd6Arr = [];
$class = '';
switch ($frmType) {
    case Configurations::FORM_GENERAL:
        if (1 > $lang_id) {
            $colMd6Arr = ['CONF_SITE_OWNER_EMAIL', 'CONF_SITE_PHONE', 'CONF_SITE_FAX', 'CONF_ABOUT_US_PAGE', 'CONF_PRIVACY_POLICY_PAGE', 'CONF_GDPR_POLICY_PAGE', 'CONF_COOKIES_BUTTON_LINK', 'CONF_TERMS_AND_CONDITIONS_PAGE'];
        } else {
            $colMd6Arr = ['lang_id', 'CONF_WEBSITE_NAME_' . $lang_id, 'CONF_SITE_OWNER_' . $lang_id];
        }
        $class = 'card-tabs';
        break;
    case Configurations::FORM_LOCAL:
        if (1 > $lang_id) {
            $colMd6Arr = ['CONF_DEFAULT_SITE_LANG', 'CONF_TIMEZONE', 'CONF_COUNTRY', 'CONF_ZIP_CODE', 'CONF_STATE', 'CONF_DATE_FORMAT', 'CONF_DEFAULT_CURRENCY_SEPARATOR', 'CONF_FAQ_PAGE_MAIN_CATEGORY', 'CONF_SELLER_PAGE_MAIN_CATEGORY', 'CONF_CURRENCY'];
        } else {
            $colMd6Arr = ['lang_id', 'CONF_CITY_' . $lang_id, 'CONF_ADDRESS_' . $lang_id, 'CONF_ADDRESS_LINE_2_' . $lang_id];
        }
        $class = 'card-tabs';
        break;
    case Configurations::FORM_SEO:
        if (1 > $lang_id) {
            $colMd6Arr = ['CONF_TWITTER_USERNAME', 'googleFileVerification', 'google_file_verification', 'bingFileVerification', 'bing_file_verification'];
        }
        break;
    case Configurations::FORM_USER_ACCOUNT:
        if (1 > $lang_id) {
            $colMd6Arr = ['CONF_MAX_SUPPLIER_REQUEST_ATTEMPT', 'CONF_MIN_WITHDRAW_LIMIT', 'CONF_MAX_WITHDRAW_LIMIT', 'CONF_MIN_INTERVAL_WITHDRAW_REQUESTS'];
        }
        break;
    case Configurations::FORM_CART_WISHLIST:
        if (1 > $lang_id) {
            $colMd6Arr = ['CONF_REMINDER_INTERVAL_PRODUCTS_IN_CART', 'CONF_SENT_CART_REMINDER_COUNT', 'CONF_REMINDER_INTERVAL_PRODUCTS_IN_WISHLIST', 'CONF_SENT_WISHLIST_REMINDER_COUNT'];
        }
        break;
    case Configurations::FORM_CHECKOUT_PROCESS:
        if (1 > $lang_id) {
            $colMd6Arr = ['CONF_MIN_COD_ORDER_LIMIT', 'CONF_MAX_COD_ORDER_LIMIT', 'CONF_COD_MIN_WALLET_BALANCE', 'CONF_TIME_SLOT_ADDITION', 'CONF_DEFAULT_ORDER_STATUS', 'CONF_DEFAULT_PAID_ORDER_STATUS', 'CONF_DEFAULT_APPROVED_ORDER_STATUS', 'CONF_DEFAULT_INPROCESS_ORDER_STATUS', 'CONF_DEFAULT_SHIPPING_ORDER_STATUS', 'CONF_DEFAULT_DEIVERED_ORDER_STATUS', 'CONF_DEFAULT_CANCEL_ORDER_STATUS', 'CONF_RETURN_REQUEST_ORDER_STATUS', 'CONF_RETURN_REQUEST_WITHDRAWN_ORDER_STATUS', 'CONF_RETURN_REQUEST_APPROVED_ORDER_STATUS', 'CONF_PAY_AT_STORE_ORDER_STATUS', 'CONF_COD_ORDER_STATUS', 'CONF_PICKUP_READY_ORDER_STATUS', 'CONF_DEFAULT_COMPLETED_ORDER_STATUS', 'CONF_DEFAULT_RETURN_AGE'];
        }
        break;
    case Configurations::FORM_EMAIL:
        $class = 'card-tabs';
        break;

    case Configurations::FORM_PRODUCT:
        if (1 > $lang_id) {
            $colMd6Arr = ['CONF_FULFILLMENT_TYPE', 'CONF_ITEMS_PER_PAGE_CATALOG', 'CONF_DEFAULT_GEO_LOCATION', 'CONF_GEO_DEFAULT_COUNTRY', 'CONF_GEO_DEFAULT_STATE', 'CONF_GEO_DEFAULT_ZIPCODE'];
        }

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
    case Configurations::FORM_SERVER:
        $class = 'card-tabs';
        break;
}

if (!empty($colMd6Arr)) {
    foreach ($colMd6Arr as $val) {
        $fld = $frm->getField($val);
        $fld->developerTags['colWidthValues'] = [null, '6', null, null];
    }
}

?>
<div class="card <?php echo $class; ?>">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title">
                <?php echo $tabs[$frmType] . ' ' . Labels::getLabel('LBL_SETTINGS', $siteLangId); ?>
            </h3>

        </div>
        <div class="card-head-toolbar">
            <?php if ($dispLangTab && $frmType != Configurations::FORM_MEDIA && $frmType != Configurations::FORM_SHARING) { ?>

                <nav class="nav nav-tabs navTabsJs">
                    <a class="nav-link <?php echo ($lang_id == 0) ? 'active' : ''; ?>" href="javascript:void(0)" onClick="getForm(<?php echo $frmType; ?>)">
                        <?php echo Labels::getLabel('LBL_Basic', $siteLangId); ?>
                    </a>

                    <a class="nav-link <?php echo (0 < $lang_id ? 'active' : '') ?>" href="javascript:void(0);" onClick="getLangForm(<?php echo $frmType; ?>, <?php echo FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1); ?>)">
                        <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                    </a>
                </nav>

            <?php } ?>
        </div>
    </div>


    <div class="card-body">
        <div class="formBodyJs">
            <?php echo str_replace('<i class="input-helper"></i>', '<span></span>', $frm->getFormHtml()); ?>
            <?php if ($displayMap && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
                <div id="map" style="height:500px"></div>
            <?php } ?>
        </div>
    </div>

    <div class="card-foot">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_RESET', $siteLangId), 'button', 'btn_reset_form', 'btn btn-outline-brand resetModalFormJs'); ?>
                    </div>
                    <div class="col-auto">
                        <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_SAVE', $siteLangId), 'button', 'btn_save', 'btn btn-brand gb-btn gb-btn-primary submitBtnJs'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    <?php if ($displayMap && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
        getStatesByCountryCode($("#geo_country_code").val(),
            '<?php echo FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_STRING, 1); ?>', '#geo_state_code',
            'state_code');
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