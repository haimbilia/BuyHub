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
} ?>

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
            <!--<input type="hidden" name="selected_ship_zone"> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-4 zone-main-field--js">
                        <input type="text" placeholder="<?php echo Labels::getLabel("LBL_Zone_Name", $siteLangId); ?>" name="shipzone_name" class="form-control shipzone_name" value="<?php echo (!empty($zone_data)) ? $zone_data['shipzone_name'] : ''; ?>" required>
                        <span class="form-text text-muted"><?php echo Labels::getLabel("LBL_Customers_will_not_see_this.", $siteLangId); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="list-zones">
                        <div class="list-zones-search sticky-top">
                            <input type="search" class="form-control omni-search" name="search" value="" placeholder="<?php echo Labels::getLabel('FRM_SEARCH', $siteLangId); ?>">
                        </div>
                        <div class="list-zones-head">
                            <label class="checkbox" data-zoneid="-1">
                                <input type="checkbox" name="rest_of_the_world" value="-1" class="checkbox_zone_-1" <?php echo (in_array(-1, $zoneIds)) ? 'checked' : ''; ?> <?php echo (in_array(-1, $exZoneIds)) ? 'disabled' : ''; ?>>
                                <i class="input-helper"></i>
                                <?php echo Labels::getLabel("LBL_REST_OF_THE_WORLD", $siteLangId); ?>
                            </label>

                        </div>
                        <div class="checkbox_container--js">
                            <?php
                            if (!empty($zones)) {
                                foreach ($zones as $zone) {
                                    $countCounties = 0;
                                    if (!empty($zoneCountries)) {
                                        $cZoneCountries = (isset($zoneCountries[$zone['zone_id']])) ? $zoneCountries[$zone['zone_id']] : array();
                                        $countCounties = count(array_unique($cZoneCountries));
                                    }
                                    $countries = (isset($zone['countries'])) ? $zone['countries'] : array();
                                    $totalCountries = count($countries);
                            ?>
                                    <div class="list-zones-head">
                                        <label class="checkbox zone--js" data-zoneid="<?php echo $zone['zone_id']; ?>">
                                            <input type="checkbox" name="shiploc_zone_ids[]" value="<?php echo $zone['zone_id']; ?>" class="countries-js checkbox_zone_<?php echo $zone['zone_id']; ?>" <?php echo ($countCounties == $totalCountries && $countCounties != 0) ? 'checked' : ''; ?>>

                                            <?php echo $zone['zone_name']; ?>
                                        </label>
                                        <button type="button" class="out-of-state dropdown-toggle-custom" data-bs-toggle="collapse" data-bs-target="#zone_<?php echo $zone['zone_id']; ?>" aria-expanded="false" aria-controls="zone_<?php echo $zone['zone_id']; ?>">
                                            <i class="dropdown-toggle-custom-arrow"></i>
                                        </button>
                                    </div>
                                    <?php if (!empty($countries)) { ?>
                                        <ul class="list-states collapse  zone_<?php echo $zone['zone_id']; ?>" id="zone_<?php echo $zone['zone_id']; ?>">
                                            <?php
                                            foreach ($countries as $country) {
                                                $statesCount = count($country['states']);
                                                $countryId = $country['country_id'];
                                                $disabled = '';
                                                $checked = '';
                                                $countryStates = [];
                                                //$exCountryStates = [];
                                                if (!empty($countryStatesArr) && isset($countryStatesArr[$countryId])) {
                                                    $countryStates = $countryStatesArr[$countryId];
                                                }
                                                if (!empty($countryStates) && in_array('-1', $countryStates)) {
                                                    $checked = 'checked';
                                                }
                                                if (!empty($excludeCountryStates) && isset($excludeCountryStates[$countryId])) {
                                                    $disabled = 'disabled';
                                                }
                                            ?>
                                                <li class="list-states-item">
                                                    <div class="list-zones-head">
                                                        <label class="checkbox country--js " data-countryid="<?php echo $countryId; ?>" data-statecount="<?php echo $statesCount; ?>">
                                                            <input type="checkbox" name="c_id[]" value="<?php echo $zone['zone_id']; ?>-<?php echo $countryId; ?>" class="checkbox_country_<?php echo $countryId; ?>" <?php echo $checked; ?>>
                                                            <?php echo $country['country_name']; ?>
                                                        </label>
                                                        <?php if ($statesCount > 0) { ?>
                                                            <button type="button" class="out-of-state dropdown-toggle-custom collapsed link_<?php echo $countryId; ?> containChild-js" data-bs-toggle="collapse" data-bs-target="#state_list_<?php echo $countryId; ?>" aria-expanded="false" aria-controls="state_list_<?php echo $countryId; ?>" data-countryid="<?php echo $countryId; ?>" data-loadedstates="1">
                                                                <span class="statecount--js selectedStateCount--js_<?php echo $countryId; ?> " data-totalcount="<?php echo $statesCount; ?>">0</span>

                                                                <?php echo Labels::getLabel("LBL_of", $siteLangId); ?>
                                                                <span class="totalStates "><?php echo $statesCount; ?>
                                                                </span>
                                                                <i class="dropdown-toggle-custom-arrow"></i>
                                                            </button>
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
                                                                if (isset($excludeCountryStates[$countryId]) && in_array($state['state_id'], $excludeCountryStates[$countryId])) {
                                                                    $stateDisabled = ' disabled';
                                                                }
                                                            ?>
                                                                <li class="list-states-item">
                                                                    <div class="list-zones-head">
                                                                        <label class="checkbox" data-stateid="<?php echo $state['state_id']; ?>">
                                                                            <input type="checkbox" name="s_id[]" value="<?php echo $zone['zone_id']; ?>-<?php echo $countryId; ?>-<?php echo $state['state_id']; ?>" class="state--js" <?php echo $stateChecked; ?> <?php echo $stateDisabled; ?>>
                                                                            <?php echo $state['state_name']; ?>
                                                                        </label>
                                                                    </div>

                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>

                                                </li>
                                            <?php }
                                            ?>
                                        </ul>
                                    <?php } ?>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="form-edit-foot">
        <div class="row">
            <div class="col">
                <button type="button" name="btn_reset_form" class="btn btn-outline-brand resetModalFormJs">Reset</button>
            </div>
            <div class="col-auto">
                <button type="button" name="btn_save" class="btn btn-brand submitBtnJs">Save</button>
            </div>
        </div>
    </div>
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