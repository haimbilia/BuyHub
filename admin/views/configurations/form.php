<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$clearFormFn = isset($clearFormFn) ? $clearFormFn : 'getForm(' . $frmType . ')';

HtmlHelper::formatFormFields($frm, 6);
$frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
$frm->setFormTagAttribute('class', 'form form--settings modalFormJs checkboxSwitchJs');
if (CommonHelper::getLayoutDirection() != $formLayout) {
    $frm->addFormTagAttribute('class', "layout--" . $formLayout);
    $frm->setFormTagAttribute('dir', $formLayout);
}
$frm->setFormTagAttribute('data-onclear', $clearFormFn);
$frm->setFormTagAttribute('id', 'frmConfSetting');

$frm->setFormTagAttribute('onsubmit', 'setup($("#frmConfSetting")); return(false);');

$stateData =  $frmType == Configurations::FORM_PRODUCT ? $stateData = FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_INT, 1) : FatApp::getConfig('CONF_STATE', FatUtility::VAR_INT, 1);
$displayMap = $frmType == Configurations::FORM_PRODUCT;
$headerHtmlContent = $headerHtmlContent ?? '';
?>
<div id="frmBlockJs" class="card setting-card">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title">
                <?php echo $tabs[$frmType]; ?>
            </h3>
        </div>
        <div class="card-head-toolbar">
            <?php if ($dispLangTab) { ?>
                <div class="input-group">
                    <select class="form-control form-select select-language" onchange="getForm(<?php echo $frmType; ?>, this.value)">
                        <?php foreach ($languagesNames as $langKey => $langName) { ?>
                            <option value="<?php echo $langKey; ?>" <?php echo $langKey == $lang_id ? "selected" : ""; ?>><?php echo $langName; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <?php if (!empty($headerHtmlContent)) {
                echo $headerHtmlContent;
            } ?>
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

    <?php if ($frmType != Configurations::FORM_MEDIA) { ?>
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
    <?php } ?>
    <script language="javascript">
        var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;

        <?php if ($displayMap && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
            getStatesByCountryCode($("#geo_country_code").val(),
                '<?php echo FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_STRING, 1); ?>', '#geo_state_code',
                'state_code');
        <?php } ?>

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
        <?php 
        $tourStep = UrlHelper::getQueryStringArr(SiteTourHelper::TOUR_STEP);
        $tourStep = is_array($tourStep) ? array_filter($tourStep) : $tourStep;
        $tourStepArr = [];
        if(!empty($tourStep)){
            $tourStepArr[SiteTourHelper::TOUR_STEP] = $tourStep;
        }
        ?>
        var tourStepUrl = '<?php echo (!empty($tourStepArr)) ? http_build_query($tourStepArr) : ''; ?>'; 
    </script>
</div>