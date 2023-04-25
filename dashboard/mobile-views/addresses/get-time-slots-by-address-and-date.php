<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
foreach ($timeSlots as $slotKey => $slot) {
    $displayTime = date("H:i:s", strtotime('+' . $pickupInterval . ' hour'));
    if ($selectedDate == date('Y-m-d') && $displayTime > $slot['tslot_from_time']) {
        unset($timeSlots[$slotKey]);
    }
}
$data = array(
    'timeSlots' => array_values($timeSlots),
    'selectedDate' => $selectedDate,
    'pickUpBy' => $pickUpBy,
    'selectedSlot' => $selectedSlot,
);

if (empty($timeSlots)) {
    $status = applicationConstants::OFF;
}
