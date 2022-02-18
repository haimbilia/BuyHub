<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
?>
<div class="card-body">
    <?php if (isset($addresses) && !empty($addresses)) { ?>
        <ul class="my-addresses">
            <?php if ($canEdit) { ?>
                <li>
                    <div class="my-addresses__body">
                        <svg class="svg btn-icon-start">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>/images/retina/sprite-actions.svg#test">
                            </use>
                        </svg>
                        <?php echo Labels::getLabel('LBL_SHOP_PICKUP_ADDRESSES', $siteLangId); ?>
                    </div>
                    <div class="my-addresses__footer">
                        <div class="actions">
                            <a href="javascript:void(0)" onclick="pickupAddressForm(0)">
                                <svg class="svg btn-icon-start" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>/images/retina/sprite-actions.svg#add">
                                    </use>
                                </svg>
                                <?php echo Labels::getLabel('LBL_ADD_NEW', $siteLangId); ?>
                            </a>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php
            if (count($addresses) == 1 && $addresses[0]['addr_is_default'] != 1) {
                $addresses[0]['addr_is_default'] = 1;
            }
            foreach ($addresses as $address) {
                $address['addr_title'] = ($address['addr_title'] == '') ? '&nbsp;' : $address['addr_title'];
            ?>
                <li class="<?php echo ($address['addr_is_default'] == 1) ? 'is-active' : ''; ?>">
                    <div class="my-addresses__body">
                        <address class="delivery-address">
                            <h5><?php echo $address['addr_name']; ?><span class="tag"><?php echo $address['addr_title']; ?></span></h5>
                            <p>
                                <?php echo $address['addr_address1'] . '<br>'; ?>
                                <?php echo (strlen($address['addr_address2']) > 0) ? $address['addr_address2'] . '<br>' : ''; ?>
                                <?php echo (strlen($address['addr_city']) > 0) ? $address['addr_city'] . ',' : ''; ?>
                                <?php echo (strlen($address['state_name']) > 0) ? $address['state_name'] . '<br>' : ''; ?>
                                <?php echo (strlen($address['country_name']) > 0) ? $address['country_name'] . '<br>' : ''; ?>
                                <?php echo (strlen($address['addr_zip']) > 0) ? Labels::getLabel('LBL_Zip:', $siteLangId) . $address['addr_zip'] . '<br>' : ''; ?>
                            </p>
                            <p class="phone-txt">
                                <i class="fas fa-mobile-alt"></i>
                                <?php
                                if (strlen($address['addr_phone']) > 0) {
                                    $addrPhone = ValidateElement::formatDialCode($address['addr_phone_dcode']) . $address['addr_phone'];
                                    echo Labels::getLabel('LBL_Phone:', $siteLangId) . $addrPhone . '<br>';
                                }
                                ?>
                            </p>
                        </address>
                    </div>
                    <div class="my-addresses__footer">
                        <div class="actions">
                            <a href="javascript:void(0)" onclick="pickupAddressForm(<?php echo $address['addr_id']; ?>, <?php echo $address['addr_lang_id']; ?>)">
                                <?php echo Labels::getLabel('LBL_Edit', $siteLangId); ?>
                            </a>
                            <a href="javascript:void(0)" onclick="removeAddress(<?php echo $address['addr_id']; ?>, <?php echo Address::TYPE_SHOP_PICKUP; ?>)">
                                <?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>
                            </a>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php
    } elseif (isset($noRecordsHtml)) {
        echo FatUtility::decodeHtmlEntities($noRecordsHtml);
    }
    ?>
</div>