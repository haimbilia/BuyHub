<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="address-info">
    <p><?php echo $address['oua_name']; ?></p>
    <p>
        <?php
        $shippingAddress = "";
        if ($address['oua_address1'] != '') {
            $shippingAddress .= $address['oua_address1'] . ', ';
        }

        if ($address['oua_address2'] != '') {
            $shippingAddress .= $address['oua_address2'];
        }
        echo $shippingAddress;
        ?>
    </p>
    <p>
        <?php
        $cityStatePin = "";
        if ($address['oua_city'] != '') {
            $cityStatePin .= $address['oua_city'] . ', ';
        }

        if ($address['oua_state'] != '') {
            $cityStatePin .= $address['oua_state'] . ', ';
        }

        if ($address['oua_zip'] != '') {
            $cityStatePin .= $address['oua_zip'];
        }

        echo $cityStatePin;
        ?>
    </p>
    <?php
    if ($address['oua_country'] != '') {
        echo '<p>' . $address['oua_country'] . '</p>';
    }
    ?>

    <?php if ($address['oua_phone'] != '') { ?>
        <p class="c-info">
            <strong>
                <i class="icn">
                    <svg width="16px" height="16px" class="svg">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#test">
                        </use>
                    </svg></i>
                <?php echo ValidateElement::formatDialCode($address['oua_phone_dcode']) . $address['oua_phone']; ?>
            </strong>
        </p>
    <?php } ?>
</div>