<?php defined('SYSTEM_INIT') or die('Invalid usage');
$optionsString = "<option value=''>" . Labels::getLabel("LBL_SELECT_STATE", $siteLangId) . "</option>";
foreach ($statesArr as $id => $stateName) {
	$selected = '';
	if ($stateId == $id) {
		$selected = 'selected';
	}
	$optionsString .= "<option value='" . $id . "' " . $selected . ">" . $stateName . "</option>";
}
echo $optionsString;
