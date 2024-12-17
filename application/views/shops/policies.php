<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$shop_city = $shop['shop_city'];
$shop_state = (strlen((string) $shop['shop_city']) > 0) ? ', ' . $shop['shop_state_name'] : $shop['shop_state_name'];
$shop_country = (strlen((string) $shop_state) > 0) ? ', ' . $shop['shop_country_name'] : $shop['shop_country_name'];
$shopLocation = $shop_city . $shop_state . $shop_country; ?>
<div class="bg-brand-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="cell">
                    <div class="shop-info">
                        <h5><?php echo $shop['shop_name']; ?></h5>
                        <p><?php echo $shopLocation; ?> <?php echo Labels::getLabel('LBL_Opened_on', $siteLangId); ?>
                            <?php echo FatDate::format($shop['shop_created_on']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 align--right"><a
                    href="<?php echo UrlHelper::generateUrl('Shops', 'View', array($shop['shop_id'])); ?>"
                    class="btn btn-outline-white btn-sm"><?php echo Labels::getLabel('LBL_Back_to_Shop', $siteLangId); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="section">
        <header class="section-head">
            <h4><?php echo Labels::getLabel('LBL_Policies', $siteLangId); ?></h4>
        </header>
        <div class="section-body">
            <div class="box box--white">
                <?php if ($shop['shop_payment_policy'] != '') { ?>
                    <div class="table table--twocols">
                        <table>
                            <tbody>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Payment', $siteLangId) ?></th>
                                    <td><?php echo (!empty($shop['shop_payment_policy'])) ? nl2br($shop['shop_payment_policy']) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if ($shop["shop_delivery_policy"] != "") { ?>
                    <div class="table table--twocols">
                        <table>
                            <tbody>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Shipping', $siteLangId) ?></th>
                                    <td><?php echo !empty($shop['shop_delivery_policy']) ? nl2br($shop['shop_delivery_policy']) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if ($shop["shop_refund_policy"] != "") { ?>
                    <div class="table table--twocols">
                        <table>
                            <tbody>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Refunds_Exchanges', $siteLangId) ?></th>
                                    <td><?php echo !empty($shop['shop_refund_policy']) ? nl2br($shop['shop_refund_policy']) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if ($shop["shop_additional_info"] != "") { ?>
                    <div class="table table--twocols">
                        <table>
                            <tbody>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Additional_Policies_FAQs', $siteLangId) ?></th>
                                    <td><?php echo !empty($shop['shop_additional_info']) ? nl2br($shop['shop_additional_info']) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if ($shop["shop_seller_info"] != "") { ?>
                    <div class="table table--twocols">
                        <table>
                            <tbody>
                                <tr>
                                    <th><?php echo Labels::getLabel('LBL_Seller_Information', $siteLangId) ?></th>
                                    <td><?php echo !empty($shop['shop_seller_info']) ? nl2br($shop['shop_seller_info']) : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>ane
        </div>
    </div>

</div>