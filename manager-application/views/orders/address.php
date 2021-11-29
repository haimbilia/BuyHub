<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<ul class="list-text">
    <li>
        <span class="label"><?php echo Labels::getLabel('LBL_CONTACT_NAME', $siteLangId); ?> </span>
        <span class="value"><?php echo $address['oua_name']; ?></span>
    </li>
    <?php if ($address['oua_address1'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_1', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_address1']; ?></span>
        </li>
    <?php } ?>
    <?php if ($address['oua_address1'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_1', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_address1']; ?></span>
        </li>
    <?php } ?>
    <?php if ($address['oua_address2'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_2', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_address2']; ?></span>
        </li>
    <?php } ?>
    <?php if ($address['oua_city'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_CITY', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_city']; ?></span>
        </li>
    <?php } ?>
    <?php if ($address['oua_state'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_STATE', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_state']; ?></span>
        </li>
    <?php } ?>
    <?php if ($address['oua_zip'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_ZIP', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_zip']; ?></span>
        </li>
    <?php } ?>
    <?php if ($address['oua_country'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_COUNTRY', $siteLangId); ?> </span>
            <span class="value"><?php echo $address['oua_country']; ?></span>
        </li>
    <?php } ?>
    <?php if ($address['oua_phone'] != '') { ?>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_PHONE', $siteLangId); ?> </span>
            <span class="value"><?php echo ValidateElement::formatDialCode($address['oua_phone_dcode']) . $address['oua_phone']; ?></span>
        </li>
    <?php } ?>
</ul>