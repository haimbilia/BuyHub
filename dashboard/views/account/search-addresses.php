<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($addresses)) {
    if (count($addresses) == 1 && $addresses[0]['addr_is_default'] != 1) {
        $addresses[0]['addr_is_default'] = 1;
    } ?>
    <ul class="my-addresses">
        <li class="my-addresses-item my-addresses-add">
            <button class="btn btn-add-address" type="button" onclick="addAddressForm(0)">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg mb-4" width="52" height="52" viewBox="0 0 24 24" fill="#000000">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M20 1v3h3v2h-3v3h-2V6h-3V4h3V1h2zm-8 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm1-9.94v2.02A6.53 6.53 0 0 0 12 5c-3.35 0-6 2.57-6 6.2 0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.79 6-9.14V11h2v.2c0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 6.22 7.8 3 12 3c.34 0 .67.02 1 .06z" />
                </svg>
                <?php echo Labels::getLabel('LBL_ADD_NEW_ADDRESS', $siteLangId); ?>
            </button>
        </li>
        <?php foreach ($addresses as $address) {
            $address['addr_title'] = ($address['addr_title'] == '') ? '&nbsp;' : $address['addr_title']; ?>
            <li class="<?php echo ($address['addr_is_default'] == 1) ? 'is-active' : ''; ?>">
                <label class="my-addresses__body">
                    <span class="radio">
                        <?php
                        $action = "setDefaultAddress(" . $address['addr_id'] . ", event)";
                        if (1 == $address['addr_is_default']) {
                            $action = 'return false';
                        }
                        ?>
                        <input type="radio" <?php echo ($address['addr_is_default'] == 1) ? 'checked=""' : ''; ?> name="1" onclick="<?php echo $action; ?>">
                    </span>
                    <address class="delivery-address">
                        <h5><?php echo $address['addr_name']; ?><span class="tag"><?php echo $address['addr_title']; ?></span>
                        </h5>
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
                            $addrPhone = (strlen($address['addr_phone']) > 0) ? $address['addr_phone'] : '';
                            if (!empty($addrPhone) && array_key_exists('addr_phone_dcode', $address)) {
                                $addrPhone = ValidateElement::formatDialCode($address['addr_phone_dcode']) . $addrPhone;
                            }
                            echo (!empty($addrPhone)) ? Labels::getLabel('LBL_Phone:', $siteLangId) . $addrPhone . '<br>' : ''; ?>
                        </p>
                    </address>
                </label>
                <div class="my-addresses__footer">
                    <div class="actions">
                        <a href="javascript:void(0)" onclick="addAddressForm(<?php echo $address['addr_id']; ?>, <?php echo $address['addr_lang_id']; ?>)">
                            <?php echo Labels::getLabel('LBL_Edit', $siteLangId); ?>
                        </a>
                        <a href="javascript:void(0)" onclick="removeAddress(<?php echo $address['addr_id']; ?>)">
                            <?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>
                        </a>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
<?php } elseif (isset($noRecordsHtml)) { ?>
    <ul class="my-addresses">
        <li class="my-addresses-item my-addresses-add">
            <button class="btn btn-add-address" type="button" onclick="addAddressForm(0)">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg mb-4" width="52" height="52" viewBox="0 0 24 24" fill="#000000">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M20 1v3h3v2h-3v3h-2V6h-3V4h3V1h2zm-8 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm1-9.94v2.02A6.53 6.53 0 0 0 12 5c-3.35 0-6 2.57-6 6.2 0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.79 6-9.14V11h2v.2c0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 6.22 7.8 3 12 3c.34 0 .67.02 1 .06z" />
                </svg>
                <?php echo Labels::getLabel('LBL_ADD_NEW_ADDRESS', $siteLangId); ?>
            </button>
        </li>
        <li><?php echo FatUtility::decodeHtmlEntities($noRecordsHtml); ?></li>
    </ul>

<?php } ?>