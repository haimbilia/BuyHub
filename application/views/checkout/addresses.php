<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php if ($fulfillmentType == Shipping::FULFILMENT_PICKUP || $addressType == Address::ADDRESS_TYPE_BILLING || !$cartHasPhysicalProduct) {
            echo Labels::getLabel('LBL_Billing_Address', $siteLangId);
        } else {
            echo Labels::getLabel('LBL_Delivery_Address', $siteLangId);
        }
        ?>
    </h5>
</div>

<div class="modal-body form-edit">
    <form class="form">
        <div class="form-edit-body loaderContainerJs">
            <div class="row">
                <div class="col-md12">
                    <?php if ($addresses) { ?>
                        <ul class="list-addresses scroll scroll-y">
                            <?php foreach ($addresses as $address) {
                                $selected_shipping_address_id = (!$selected_shipping_address_id && $address['addr_is_default']) ? $address['addr_id'] : $selected_shipping_address_id; ?>
                                <?php $checked = false;
                                if ($addressType == 0 && $selected_shipping_address_id == $address['addr_id']) {
                                    $checked = true;
                                }
                                if ($addressType == Address::ADDRESS_TYPE_BILLING && $selected_billing_address_id == $address['addr_id']) {
                                    $checked = true;
                                }
                                ?>
                                <li class="list-addresses-item addrListJs s-<?php echo $address['addr_id']; ?> <?php echo ($checked == true) ? 'is-active' : '' ?>">
                                    <label class="addresses" for="s-<?php echo $address['addr_id']; ?>">
                                        <span class="radio addresses-checkbox">
                                            <input <?php echo ($checked == true) ? 'checked="checked"' : ''; ?> name="shipping_address_id" value="<?php echo $address['addr_id']; ?>" type="radio" id="s-<?php echo $address['addr_id']; ?>">
                                        </span>
                                        <div class="addresses-detail">
                                            <h5 class="h5">
                                                <?php echo $address['addr_name']; ?><span class="tag"><?php echo ($address['addr_title'] != '') ? $address['addr_title'] : $address['addr_name']; ?></span>
                                            </h5>
                                            <p>
                                                <?php echo $address['addr_address1']; ?>
                                                <?php if (strlen($address['addr_address2']) > 0) {
                                                    echo ", " . $address['addr_address2']; ?>
                                                <?php } ?>
                                            </p>
                                            <p><?php echo $address['addr_city'] . ", " . $address['state_name'] . ", " . $address['country_name'] . ", " . $address['addr_zip']; ?>
                                            </p>
                                            <?php if (strlen($address['addr_phone']) > 0) {
                                                $addrPhone = ValidateElement::formatDialCode($address['addr_phone_dcode']) . $address['addr_phone'];
                                            ?>
                                                <p class="phone-txt"><i class="fas fa-mobile-alt"></i><?php echo $addrPhone; ?></p>
                                            <?php } ?>
                                        </div>
                                        <?php if (!commonhelper::isAppUser()) { ?>
                                            <div class="addresses-actions">
                                                <button class="btn btn-icon btn-addresses" type="button" onClick="editAddress('<?php echo $address['addr_id']; ?>', '<?php echo $addressType; ?>')">

                                                    <?php echo Labels::getLabel('LBL_Edit', $siteLangId); ?>
                                                </button>
                                                <?php if ($selected_billing_address_id != $address['addr_id']) { ?>
                                                    <button class="btn btn-icon btn-addresses" type="button" onclick="removeAddress('<?php echo $address['addr_id']; ?>', '<?php echo $addressType; ?>')">
                                                        <?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </label>
                                </li>
                            <?php } ?>
                            <li class="list-addresses-item addrListJs">
                                <div class="addresses-detail">
                                    <button class="btn btn-add-address" type="button" onclick="showAddressFormDiv(<?php echo $addressType; ?>);">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg mb-4" width="52" height="52" viewBox="0 0 24 24" fill="#000000">
                                            <path d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20 1v3h3v2h-3v3h-2V6h-3V4h3V1h2zm-8 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm1-9.94v2.02A6.53 6.53 0 0 0 12 5c-3.35 0-6 2.57-6 6.2 0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.79 6-9.14V11h2v.2c0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 6.22 7.8 3 12 3c.34 0 .67.02 1 .06z" />
                                        </svg>
                                        <?php echo Labels::getLabel('LBL_ADD_NEW_ADDRESS', $siteLangId); ?>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="form-edit-foot">
            <div class="row">
                <?php
                $backJsFunc = 'showAddressList();';
                $contiJsFunc = 'setUpAddressSelection();';
                if ($addressType == Address::ADDRESS_TYPE_BILLING) {
                    $backJsFunc = 'loadPaymentSummary();';
                    $contiJsFunc = 'setUpBillingAddressSelection(this);';
                }
                ?>
                <div class="col">
                    <button type="button" class="btn btn-outline-gray btn-wide" onclick="<?php echo $backJsFunc; ?>">
                        <?php echo Labels::getLabel('LBL_RESET', $siteLangId); ?>
                    </button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-brand btn-wide" id="btn-continue-js" onclick="<?php echo $contiJsFunc; ?>" title="<?php echo Labels::getLabel('LBL_SET_SELECTED_ADDRESS_AS_SHIPPING_ADDRESS', $siteLangId); ?>" data-bs-toggle="tooltip">
                        <?php echo Labels::getLabel('LBL_SAVE', $siteLangId); ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>