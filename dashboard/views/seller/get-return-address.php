<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>

<div class="card-body">
    <ul class="my-addresses">
        <?php if (!isset($addressData) || empty($addressData)) { ?>
            <li class="my-addresses-item my-addresses-add">
                <button class="btn btn-add-address" type="button" onclick="returnAddressForm()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg mb-4" width="52" height="52" viewBox="0 0 24 24" fill="#000000">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M20 1v3h3v2h-3v3h-2V6h-3V4h3V1h2zm-8 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm1-9.94v2.02A6.53 6.53 0 0 0 12 5c-3.35 0-6 2.57-6 6.2 0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.79 6-9.14V11h2v.2c0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 6.22 7.8 3 12 3c.34 0 .67.02 1 .06z" />
                    </svg>
                    <?php echo Labels::getLabel('LBL_ADD_NEW_ADDRESS', $siteLangId); ?>
                </button>
            </li>
        <?php } else { ?>
            <li class="my-addresses-item">
                <div class="my-addresses__body">
                    <address class="delivery-address">
                        <h5><?php echo $addressData['ura_name']; ?></h5>
                        <p>
                            <?php echo $addressData['ura_address_line_1'] . '<br>'; ?>
                            <?php echo (strlen($addressData['ura_address_line_2']) > 0) ? $addressData['ura_address_line_2'] . '<br>' : ''; ?>
                            <?php echo (strlen($addressData['ura_city']) > 0) ? $addressData['ura_city'] . ',' : ''; ?>
                            <?php echo (strlen($addressData['state_name']) > 0) ? $addressData['state_name'] . '<br>' : ''; ?>
                            <?php echo (strlen($addressData['country_name']) > 0) ? $addressData['country_name'] . '<br>' : ''; ?>
                            <?php echo (strlen($addressData['ura_zip']) > 0) ? Labels::getLabel('LBL_Zip:', $siteLangId) . $addressData['ura_zip'] . '<br>' : ''; ?>
                        </p>
                        <p class="phone-txt">
                            <i class="fas fa-mobile-alt"></i>
                            <?php
                            if (strlen($addressData['ura_phone']) > 0) {
                                $addrPhone = ValidateElement::formatDialCode($addressData['ura_phone_dcode']) . $addressData['ura_phone'];
                                echo Labels::getLabel('LBL_Phone:', $siteLangId) . $addrPhone . '<br>';
                            }
                            ?>
                        </p>
                    </address>
                </div>
                <div class="my-addresses__footer">
                    <div class="actions">
                        <a href="javascript:void(0)" onclick="returnAddressForm()">
                            <?php echo Labels::getLabel('LBL_Edit', $siteLangId); ?>
                        </a>
                        <a href="javascript:void(0)" onclick="deleteReturnAddress()">
                            <?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>
                        </a>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>