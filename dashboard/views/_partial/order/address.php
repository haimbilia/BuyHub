<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="address-info">
    <ul class="list-stats list-stats-double">
        <li class="list-stats-item">
            <span class="label"><?php echo Labels::getLabel('LBL_CONTACT_NAME', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_name']; ?></span>
        </li>
        <?php if ($address['oua_address1'] != '') { ?>
            <li class="list-stats-item list-stats-item-full">
                <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_1', $siteLangId); ?> </span>
                <span class="value"><?php echo $address['oua_address1']; ?></span>
            </li>
        <?php } ?>
        <?php if ($address['oua_address2'] != '') { ?>
            <li class="list-stats-item list-stats-item-full">
                <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_2', $siteLangId); ?> </span>
                <span class="value"><?php echo $address['oua_address2']; ?></span>
            </li>
        <?php } ?>
        <?php if ($address['oua_city'] != '') { ?>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_CITY', $siteLangId); ?> </span>
                <span class="value"><?php echo $address['oua_city']; ?></span>
            </li>
        <?php } ?>
        <?php if ($address['oua_state'] != '') { ?>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_STATE', $siteLangId); ?> </span>
                <span class="value"><?php echo $address['oua_state']; ?></span>
            </li>
        <?php } ?>
        <?php if ($address['oua_zip'] != '') { ?>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_ZIP', $siteLangId); ?> </span>
                <span class="value"><?php echo $address['oua_zip']; ?></span>
            </li>
        <?php } ?>
        <?php if ($address['oua_country'] != '') { ?>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_COUNTRY', $siteLangId); ?> </span>
                <span class="value"><?php echo $address['oua_country']; ?></span>
            </li>
        <?php } ?>
        <?php if ($address['oua_phone'] != '') { ?>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_PHONE', $siteLangId); ?> </span>
                <span class="value"><span class="default-ltr"><?php echo ValidateElement::formatDialCode($address['oua_phone_dcode']) . $address['oua_phone']; ?></span></span>
            </li>
        <?php } ?>
        <?php
        $pickupFromTime = $childOrderDetail['opshipping_time_slot_from'] ?? '';
        $pickupToTime = $childOrderDetail['opshipping_time_slot_to'] ?? '';
        if (!empty($pickupFromTime) && '00:00:00' != $pickupFromTime && !empty($pickupToTime) && '00:00:00' != $pickupToTime) { ?>
            <li class="list-stats-item">
                <span class="label"><?php echo Labels::getLabel('LBL_PICKUP_TIME', $siteLangId); ?> </span>
                <span class="value"><?php echo date('H:i', strtotime($pickupFromTime)) . ' - ' . date('H:i', strtotime($pickupToTime)); ?></span>
            </li>
        <?php } ?>
    </ul>
</div>