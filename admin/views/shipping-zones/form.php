<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$zoneIds = [];
$countryStatesArr = [];
$zoneCountries = [];

if (!empty($zoneLocations)) {
    $zoneIds = array_column($zoneLocations, 'shiploc_zone_id');
    $zoneIds = array_unique(array_map('intval', $zoneIds));
    foreach ($zoneLocations as $location) {
        $selectedCountryId = $location['shiploc_country_id'];
        $selectedStateId = $location['shiploc_state_id'];
        $selectedZoneId = $location['shiploc_zone_id'];
        $zoneCountries[$selectedZoneId][] = $selectedCountryId;
        $countryStatesArr[$selectedCountryId][] = $selectedStateId;
    }
}

$excludeCountryStates = [];
$exZoneIds = [];

if (!empty($excludeLocations)) {
    $exZoneIds = array_column($excludeLocations, 'shiploc_zone_id');
    $exZoneIds = array_unique(array_map('intval', $exZoneIds));
    foreach ($excludeLocations as $exLocation) {
        $disableCountryId = $exLocation['shiploc_country_id'];
        $disableStateId = $exLocation['shiploc_state_id'];
        $excludeCountryStates[$disableCountryId][] = $disableStateId;
    }
}
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_Zone_Setup', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit loaderContainerJs">
    <div class="form-edit-body">
        <form onsubmit="setupZone(this); return(false);" method="post" class="form modalFormJs" id="shippingZoneFrm" data-onclear="zoneForm(<?php echo $profile_id; ?>, <?php echo $zone_id; ?>)">
            <input type="hidden" name="shipprozone_id" value="<?php echo (!empty($zone_data)) ? $zone_data['shipprozone_id'] : 0; ?>">
            <input type="hidden" name="shipzone_id" value="<?php echo $zone_id; ?>">
            <input type="hidden" name="shipzone_profile_id" value="<?php echo $profile_id; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-4 zone-main-field--js">
                        <input type="text" placeholder="<?php echo Labels::getLabel("LBL_ZONE_NAME*", $siteLangId); ?>" name="shipzone_name" class="form-control shipzone_name" value="<?php echo (!empty($zone_data)) ? $zone_data['shipzone_name'] : ''; ?>" required="required" data-field-caption="<?php echo Labels::getLabel("LBL_Zone_Name", $siteLangId); ?>" data-fatreq="{'required':true}">
                        <span class="form-text text-muted"><?php echo Labels::getLabel("LBL_Customers_will_not_see_this.", $siteLangId); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="list-zones">
                        <div class="list-zones-search sticky-top">
                            <input type="search" class="form-control omni-search continentJs" autocomplete="off" name="search" value="" placeholder="<?php echo Labels::getLabel('FRM_SEARCH_BY_CONTINENT_NAME,_COUNTRY_NAME_OR_STATE_NAME', $siteLangId); ?>" data-bs-toggle="tooltip" title="<?php echo Labels::getLabel('FRM_SEARCH_BY_CONTINENT_NAME,_COUNTRY_NAME_OR_STATE_NAME', $siteLangId); ?>">
                        </div>
                        <div class="list-zones-head">
                            <label class="checkbox" data-zoneid="-1">
                                <input type="checkbox" name="rest_of_the_world" value="-1" class="checkbox_zone_-1" <?php echo (in_array(-1, $zoneIds)) ? 'checked' : ''; ?> <?php echo (in_array(-1, $exZoneIds)) ? 'disabled' : ''; ?>>
                                <i class="input-helper"></i>
                                <?php echo Labels::getLabel("LBL_REST_OF_THE_WORLD", $siteLangId); ?>
                            </label>
                        </div>
                        <div class="checkbox_container--js">
                            <?php if (!empty($zones)) {
                                foreach ($zones as $zone) {
                                    $countCounties = 0;
                                    if (!empty($zoneCountries)) {
                                        $cZoneCountries = (isset($zoneCountries[$zone['zone_id']])) ? $zoneCountries[$zone['zone_id']] : array();
                                        $countCounties = count(array_unique($cZoneCountries));
                                    }
                                    $countries = (isset($zone['countries'])) ? $zone['countries'] : array();
                                    $totalCountries = count($countries); ?>
                                    <div class="zones--js">
                                        <div class="list-zones-head zone-name--js">
                                            <label class="checkbox zone--js" data-zoneid="<?php echo $zone['zone_id']; ?>">
                                                <input type="checkbox" name="shiploc_zone_ids[]" value="<?php echo $zone['zone_id']; ?>" class="countries-js checkbox_zone_<?php echo $zone['zone_id']; ?>" <?php echo ($countCounties == $totalCountries && $countCounties != 0) ? 'checked' : ''; ?>>
                                                <?php echo $zone['zone_name']; ?>
                                            </label>
                                            <label class="out-of-state dropdown-toggle-custom collapsed" data-bs-toggle="collapse" data-bs-target="#zone_<?php echo $zone['zone_id']; ?>" aria-expanded="false" aria-controls="zone_<?php echo $zone['zone_id']; ?>">
                                                <i class="dropdown-toggle-custom-arrow"></i>
                                            </label>
                                        </div>
                                        <?php if (!empty($countries)) { ?>
                                            <ul class="zones-states--js zone-countries--js list-states collapse  zone_<?php echo $zone['zone_id']; ?>" id="zone_<?php echo $zone['zone_id']; ?>">
                                                <?php foreach ($countries as $country) {
                                                    $statesCount = count($country['states']);
                                                    $countryId = $country['country_id'];
                                                    $disabled = $disabledJs = '';
                                                    $checked = '';
                                                    $countryStates = [];
                                                    $alreadyAddedMsg = '';
                                                    //$exCountryStates = [];
                                                    if (!empty($countryStatesArr) && isset($countryStatesArr[$countryId])) {
                                                        $countryStates = $countryStatesArr[$countryId];
                                                    }
                                                    if (!empty($countryStates) && in_array('-1', $countryStates)) {
                                                        $checked = 'checked';
                                                    }

                                                    $countrySelected = $excludeCountryStates[$countryId] ?? [];

                                                    if (!empty($countrySelected)) {
                                                        $disabledJs = 'disabledJs ';
                                                        $disabled = 'disabled';
                                                        $alreadyAddedMsg = Labels::getLabel('LBL_ALREADY_SELECTED_IN_OTHER_ZONE', $siteLangId);
                                                    } ?>
                                                    <li class="list-states-item filter-country--js">
                                                        <div class="list-zones-head">
                                                            <label class="checkbox country--js <?php echo $disabledJs . $disabled; ?>" data-countryid="<?php echo $countryId; ?>" data-statecount="<?php echo $statesCount; ?>">
                                                                <input type="checkbox" name="c_id[]" value="<?php echo $zone['zone_id']; ?>-<?php echo $countryId; ?>" class="checkbox_country_<?php echo $countryId; ?>" <?php echo $checked; ?> <?php echo $disabled; ?> title="<?php echo $alreadyAddedMsg; ?>">
                                                                <?php echo $country['country_name']; ?>
                                                            </label>
                                                            <?php if ($statesCount > 0) { ?>
                                                                <label class="out-of-state dropdown-toggle-custom collapsed link_<?php echo $countryId; ?> containChild-js" data-bs-toggle="collapse" data-bs-target="#state_list_<?php echo $countryId; ?>" aria-expanded="false" aria-controls="state_list_<?php echo $countryId; ?>" data-countryid="<?php echo $countryId; ?>" data-loadedstates="1">
                                                                    <span class="statecount--js selectedStateCount--js_<?php echo $countryId; ?> " data-totalcount="<?php echo $statesCount; ?>">0</span>

                                                                    <?php echo Labels::getLabel("LBL_of", $siteLangId); ?>
                                                                    <span class="totalStates "><?php echo $statesCount; ?>
                                                                    </span>
                                                                    <i class="dropdown-toggle-custom-arrow"></i>
                                                                </label>
                                                            <?php } ?>
                                                        </div>

                                                        <?php if (!empty($country['states'])) { ?>
                                                            <ul class="list-states collapse country_<?php echo $countryId; ?>" class="" id="state_list_<?php echo $countryId; ?>">
                                                                <?php
                                                                foreach ($country['states'] as $state) {
                                                                    $stateChecked = '';
                                                                    $countryStates = [];
                                                                    $exCountryStates = [];

                                                                    if (!empty($countryStatesArr) && isset($countryStatesArr[$countryId])) {
                                                                        $countryStates = $countryStatesArr[$countryId];
                                                                    }
                                                                    if ((!empty($countryStates) && (in_array('-1', $countryStates) || in_array($state['state_id'], $countryStates)))) {
                                                                        $stateChecked = 'checked';
                                                                    }

                                                                    $stateDisabled = '';
                                                                    $allstatesSelected = !empty($countrySelected) ? current($countrySelected) : 0;
                                                                    if (-1 == $allstatesSelected || (!empty($countrySelected) && in_array($state['state_id'], $countrySelected))) {
                                                                        $stateDisabled = ' disabled';
                                                                    }
                                                                ?>
                                                                    <li class="list-states-item filter-state-label--js">
                                                                        <div class="list-zones-head">
                                                                            <label class="checkbox state-label--js <?php echo $stateDisabled; ?>" data-stateid="<?php echo $state['state_id']; ?>">
                                                                                <input type="checkbox" name="s_id[]" value="<?php echo $zone['zone_id']; ?>-<?php echo $countryId; ?>-<?php echo $state['state_id']; ?>" class="state--js" <?php echo $stateChecked; ?> <?php echo $stateDisabled; ?> title="<?php echo $alreadyAddedMsg; ?>">
                                                                                <?php echo $state['state_name']; ?>
                                                                            </label>
                                                                        </div>

                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>
                            <?php }
                            } ?>

                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
            shippingZoneFrm_validator_formatting = {
                "errordisplay": 3,
                "summaryElementId": ""
            };
            shippingZoneFrm_validator = $("#shippingZoneFrm").validation(shippingZoneFrm_validator_formatting);
        </script>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<?php if (0 < $zone_id) { ?>
    <script>
        setTimeout(function() {
            $('.country--js input[type="checkbox"]').each(function() {
                var countryId = $(this).closest('.country--js').data('countryid');
                var stateCount = $('.country_' + countryId + ' .state--js:checked').length;
                if (!$(this).prop("checked")) {
                    if (0 < stateCount) {
                        $('.link_' + countryId).click();
                    }
                }
                $('.selectedStateCount--js_' + countryId).text(stateCount);
            });

            $('.zone--js').each(function() {
                var zoneId = $(this).data('zoneid');
                var stateCount = $('.zone_' + zoneId + ' .state--js:checked').length;
                if (0 < stateCount && !$(this).prop("checked")) {
                    $('.containCountries-js-' + zoneId).click();
                }
            })
        }, 150);
    </script>
<?php } ?>

<script>
    setTimeout(function() {
        $('.zones--js').each(function() {
            if ($('.country--js', this).length == $('.country--js.disabledJs', this).length) {
                $(this).find('.zone--js').addClass('disabled')
                $(this).find('.zone--js input[type="checkbox"]').attr('disabled', 'disabled')
            }
        })
    }, 150);
</script>