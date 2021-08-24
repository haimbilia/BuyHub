<?php defined('SYSTEM_INIT') or die('Invalid Usage . ');
$canCancelOrder = true;
$canReturnRefund = true;
$canReviewOrders = false;
$canSubmitFeedback = false;
$selProdTotalSpecialPrice = 0;

if (true == $primaryOrder) {
    if ($childOrderDetail['op_product_type'] == Product::PRODUCT_TYPE_DIGITAL) {
        $canCancelOrder = (in_array($childOrderDetail["op_status_id"], (array) Orders::getBuyerAllowedOrderCancellationStatuses(true)));
        $canReturnRefund = (in_array($childOrderDetail["op_status_id"], (array) Orders::getBuyerAllowedOrderReturnStatuses(true)));
    } else {
        $canCancelOrder = (in_array($childOrderDetail["op_status_id"], (array) Orders::getBuyerAllowedOrderCancellationStatuses()));
        $canReturnRefund = (in_array($childOrderDetail["op_status_id"], (array) Orders::getBuyerAllowedOrderReturnStatuses()));
    }

    if (in_array($childOrderDetail["op_status_id"], SelProdReview::getBuyerAllowedOrderReviewStatuses())) {
        $canReviewOrders = true;
    }

    $canSubmitFeedback = Orders::canSubmitFeedback($childOrderDetail['order_user_id'], $childOrderDetail['order_id'], $childOrderDetail['op_selprod_id']);
    $selProdTotalSpecialPrice += $childOrderDetail['op_special_price'] * $childOrderDetail["op_qty"];


    $cartTotal = CommonHelper::orderProductAmount($childOrderDetail, 'CART_TOTAL');
    $disc = CommonHelper::orderProductAmount($childOrderDetail, 'DISCOUNT');
    $volumeDiscount = CommonHelper::orderProductAmount($childOrderDetail, 'VOLUME_DISCOUNT');
    $totalSaving = $selProdTotalSpecialPrice + abs($disc) + abs($volumeDiscount);
} else {
    $firstOrderInfo = current($childOrderDetail);
    $cartTotal = 0;
    foreach ($childOrderDetail as $childOrder) {
        $selProdTotalSpecialPrice += $childOrder['op_special_price'] * $childOrder["op_qty"];
        $cartTotal += $childOrder["op_unit_price"] * $childOrder["op_qty"];
    }
    $totalSaving = $selProdTotalSpecialPrice + $firstOrderInfo['order_discount_total'] + $firstOrderInfo['order_volume_discount_total'];
}

$opshippingDate = $timeSlotFrom = $timeSlotTo = "";
if (true == $primaryOrder) {
    $opshippingDate = isset($childOrderDetail['opshipping_date']) ? $childOrderDetail['opshipping_date'] . ' ' : '';
    $timeSlotFrom = isset($childOrderDetail['opshipping_time_slot_from']) ? date('H:i', strtotime($childOrderDetail['opshipping_time_slot_from'])) . ' - ' : '';
    $timeSlotTo = isset($childOrderDetail['opshipping_time_slot_to']) ? date('H:i', strtotime($childOrderDetail['opshipping_time_slot_to'])) : '';
}

if (!$print) { ?>
    <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<?php } ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php if (!$print) { ?>
            <div class="content-header row">
                <div class="col">
                    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                    <h2 class="content-header-title no-print">
                        <?php echo Labels::getLabel('LBL_Order_Details', $siteLangId); ?>
                    </h2>
                </div>

                <div class="col-auto">
                    <a href="<?php echo UrlHelper::generateUrl('Buyer', 'orders'); ?>" class="btn btn-outline-brand btn-sm no-print" title="<?php echo Labels::getLabel('LBL_Back_to_order', $siteLangId); ?>">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <?php if (true == $primaryOrder) { ?>
                        <div class="btn-group">
                            <?php if (!$print) { ?>
                                <?php if ($canCancelOrder) { ?>
                                    <a href="<?php echo UrlHelper::generateUrl('Buyer', 'orderCancellationRequest', array($childOrderDetail['op_id'])); ?>" class="btn btn-outline-brand btn-sm" title="<?php echo Labels::getLabel('LBL_Cancel_Order', $siteLangId); ?>">
                                        <?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?>
                                    </a>
                                <?php }
                                if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0) && $canReviewOrders && $canSubmitFeedback) {
                                ?>
                                    <a href="<?php echo UrlHelper::generateUrl('Buyer', 'orderFeedback', array($childOrderDetail['op_id'])); ?>" class="btn btn-outline-brand btn-sm" title="<?php echo Labels::getLabel('LBL_Feedback', $siteLangId); ?>">
                                        <?php echo Labels::getLabel('LBL_Feedback', $siteLangId); ?>
                                    </a>
                                <?php
                                }
                                if ($canReturnRefund) { ?>
                                    <a href="<?php echo UrlHelper::generateUrl('Buyer', 'orderReturnRequest', array($childOrderDetail['op_id'])); ?>" class="btn btn-outline-brand btn-sm" title="<?php echo Labels::getLabel('LBL_Refund', $siteLangId); ?>">
                                        <?php echo Labels::getLabel('LBL_Refund', $siteLangId); ?>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <div class="order-number">
                            <small class="sm-txt"><?php echo Labels::getLabel('LBL_ORDER_#', $siteLangId); ?></small>
                            <span class="numbers"> <?php echo (true == $primaryOrder) ? $childOrderDetail['op_invoice_number'] : $orderDetail['order_id']; ?>
                        </div>
                    </h5>
                    <div class="btn-group orders-actions">
                        <a href="javascript:void(0)" onclick="return addItemsToCart('<?php echo $orderDetail['order_id']; ?>');" class="btn btn-brand btn-sm"><?php echo Labels::getLabel('LBL_Buy_Again', $siteLangId); ?></a>
                        <a href="<?php echo (0 < $opId) ? UrlHelper::generateUrl('Account', 'viewBuyerOrderInvoice', [$orderDetail['order_id'], $opId]) : UrlHelper::generateUrl('Account', 'viewBuyerOrderInvoice', [$orderDetail['order_id']]); ?>" class="btn btn-outline-brand btn-sm" title="<?php echo Labels::getLabel('LBL_PRINT_BUYER_INVOICE', $siteLangId); ?>"><?php echo Labels::getLabel('LBL_INVOICE', $siteLangId); ?></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php 
                            $this->includeTemplate('_partial/order/right-side-block.php', $this->variables, false); 

                            $data = $this->variables + [
                                'canViewShippingCharges' => true,
                                'canViewTaxCharges' => true,
                            ];
                            $this->includeTemplate('_partial/order/left-side-block.php', $data, false); 
                        ?>
                    </div>

                    <div class="row">
                        <?php if (!empty($digitalDownloads)) { ?>
                            <div class="col-md-12 section--repeated mb-3">
                                <h6>
                                    <?php echo Labels::getLabel('LBL_Downloads', $siteLangId); ?>
                                </h6>
                                <div class="js-scrollable table-wrap scroll scroll-x">
                                    <table class="table">
                                        <thead>
                                            <tr class="">
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_#', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_File', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Language', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Download_times', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Downloaded_count', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Expired_on', $siteLangId); ?>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $sr_no = 1;
                                            foreach ($digitalDownloads as $key => $row) {
                                                $lang_name = Labels::getLabel('LBL_All', $siteLangId);
                                                if ($row['afile_lang_id'] > 0) {
                                                    $lang_name = $languages[$row['afile_lang_id']];
                                                }

                                                if ($row['downloadable']) {
                                                    $fileName = '<a href="' . UrlHelper::generateUrl('Buyer', 'downloadDigitalFile', array($row['afile_id'], $row['afile_record_id'])) . '">' . $row['afile_name'] . '</a>';
                                                } else {
                                                    $fileName = $row['afile_name'];
                                                }
                                                $downloads = '<li>
                                                                <a href="' . UrlHelper::generateUrl('Buyer', 'downloadDigitalFile', array($row['afile_id'], $row['afile_record_id'])) . '">
                                                                <i class="fa fa-download"></i>
                                                                </a>
                                                            </li>';

                                                $expiry = Labels::getLabel('LBL_N/A', $siteLangId);
                                                if ($row['expiry_date'] != '') {
                                                    $expiry = FatDate::Format($row['expiry_date']);
                                                }

                                                $downloadableCount = Labels::getLabel('LBL_N/A', $siteLangId);
                                                if ($row['downloadable_count'] != -1) {
                                                    $downloadableCount = $row['downloadable_count'];
                                                } ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $sr_no; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo '<div class="text-break">' . $fileName . '</div>'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $lang_name; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $downloadableCount; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['afile_downloaded_times']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $expiry; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row['downloadable']) {
                                                        ?>
                                                            <ul class="actions">
                                                                <?php echo $downloads; ?>
                                                            </ul>
                                                        <?php
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php $sr_no++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>


                        <?php if (!empty($digitalDownloadLinks)) { ?>
                            <div class="col-md-12 section--repeated mb-3">
                                <h6>
                                    <?php echo Labels::getLabel('LBL_Download_Links', $siteLangId); ?>
                                </h6>
                                <div class="js-scrollable table-wrap scroll scroll-x">
                                    <table class="table">
                                        <thead>
                                            <tr class="">
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_#', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Link', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Download_times', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Downloaded_count', $siteLangId); ?>
                                                </th>
                                                <th>
                                                    <?php echo Labels::getLabel('LBL_Expired_on', $siteLangId); ?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $sr_no = 1;
                                            foreach ($digitalDownloadLinks as $key => $row) {
                                                $expiry = Labels::getLabel('LBL_N/A', $siteLangId);
                                                if ($row['expiry_date'] != '') {
                                                    $expiry = FatDate::Format($row['expiry_date']);
                                                }

                                                $downloadableCount = Labels::getLabel('LBL_N/A', $siteLangId);
                                                if ($row['downloadable_count'] != -1) {
                                                    $downloadableCount = $row['downloadable_count'];
                                                }

                                                $link = ($row['downloadable'] != 1) ? Labels::getLabel('LBL_N/A', $siteLangId) : $row['opddl_downloadable_link'];
                                                $linkUrl = ($row['downloadable'] != 1) ? 'javascript:void(0)' : $row['opddl_downloadable_link'];
                                                $linkOnClick = ($row['downloadable'] != 1) ? '' : 'return increaseDownloadedCount(' . $row['opddl_link_id'] . ',' . $row['op_id'] . '); ';
                                                $linkTitle = ($row['downloadable'] != 1) ? '' : Labels::getLabel('LBL_Click_to_download', $siteLangId); ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $sr_no; ?>
                                                    </td>
                                                    <td>
                                                        <div class="text-break">
                                                            <a target="_blank" onClick="<?php echo $linkOnClick; ?> " href="<?php echo $linkUrl; ?>" data-link="<?php echo $linkUrl; ?>" title="<?php echo $linkTitle; ?>">
                                                                <?php echo $link; ?>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php echo $downloadableCount; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['opddl_downloaded_times']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $expiry; ?>
                                                    </td>
                                                </tr>
                                            <?php $sr_no++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        if (!$orderDetail['order_deleted'] && !$primaryOrder && !$orderDetail["order_payment_status"] && 'TransferBank' == $orderDetail['plugin_code']) { ?>
                            <div class="col-md-12 section--repeated mb-3">
                                <h6>
                                    <?php echo Labels::getLabel('LBL_ORDER_PAYMENTS', $siteLangId); ?>
                                </h6>
                                <div class="info--order">
                                    <?php
                                    $frm->setFormTagAttribute('onsubmit', 'updatePayment(this); return(false);');
                                    $frm->setFormTagAttribute('class', 'form');
                                    $frm->developerTags['colClassPrefix'] = 'col-md-';
                                    $frm->developerTags['fld_default_col'] = 12;


                                    $paymentFld = $frm->getField('opayment_method');
                                    $paymentFld->developerTags['col'] = 4;

                                    $gatewayFld = $frm->getField('opayment_gateway_txn_id');
                                    $gatewayFld->developerTags['col'] = 4;

                                    $amountFld = $frm->getField('opayment_amount');
                                    $amountFld->developerTags['col'] = 4;

                                    $submitFld = $frm->getField('btn_submit');
                                    $submitFld->developerTags['col'] = 4;
                                    $submitFld->addFieldTagAttribute('class', 'btn btn-brand');
                                    $submitFld->value = Labels::getLabel("LBL_SUBMIT_REQUEST", $siteLangId);
                                    echo $frm->getFormHtml(); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php if ($print) { ?>
    <script>
        $(".sidebar-is-expanded").addClass('sidebar-is-reduced').removeClass('sidebar-is-expanded');
    </script>
<?php } ?>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.printBtn-js').fadeIn();
        }, 500);
        $(document).on('click', '.printBtn-js', function() {
            $('.printFrame-js').show();
            setTimeout(function() {
                frames['frame'].print();
                $('.printFrame-js').hide();
            }, 500);
        });
    });

    function increaseDownloadedCount(linkId, opId) {
        fcom.ajax(fcom.makeUrl('buyer', 'downloadDigitalProductFromLink', [linkId, opId]), '', function(t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                $.systemMessage(ans.msg, 'alert--danger');
                return false;
            }
            /* var dataLink = $(this).attr('data-link');
            window.location.href= dataLink; */
            location.reload();
            return true;
        });
    }

    trackOrder = function(trackingNumber, courier, orderNumber) {
        $.mbsmessage(langLbl.processing, false, 'alert--process');
        fcom.ajax(fcom.makeUrl('Buyer', 'orderTrackingInfo', [trackingNumber, courier, orderNumber]), '', function(res) {
            $.mbsmessage.close();
            $.facebox(res);
        });
    };
</script>