<?php defined('SYSTEM_INIT') or die('Invalid usage');
$optionsString = '<option value="-1">' . Labels::getLabel("LBL_Select_State", $adminLangId) . '</option>';
foreach ($statesArr as $id => $stateName) {
	$selected = '';
	if ($stateId == $id) {
		$selected = 'selected';
	}
	$optionsString .= "<option value='" . $id . "' " . $selected . ">" . $stateName . "</option>";
}

echo $optionsString;
