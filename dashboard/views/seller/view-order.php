<?php

use PhpParser\Node\Stmt\Label;

defined('SYSTEM_INIT') or die('Invalid Usage.');

if (!$print) {
    $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<?php
}

$shippingCharges = CommonHelper::orderProductAmount($orderDetail, 'shipping');

$orderStatusLbl = Labels::getLabel('LBL_AWAITING_SHIPMENT', $siteLangId);
$orderStatus = '';
if (isset($orderDetail["thirdPartyorderInfo"]['orderStatus'])) {
    $orderStatus = $orderDetail["thirdPartyorderInfo"]['orderStatus'];
    $orderStatusLbl = strpos($orderStatus, "_") ? str_replace('_', ' ', $orderStatus) : $orderStatus;
}
$pickUpDetails = NULL;

$now = time(); // or your date as well
$orderDate = strtotime($orderDetail['order_date_added']);
$datediff = $now - $orderDate;
$daysSpent = round($datediff / (60 * 60 * 24));

$transferBank = (isset($orderDetail['plugin_code']) && 'TransferBank' == $orderDetail['plugin_code']);
?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php if (!$print) { ?>
            <div class="content-header row">
                <div class="col">
                    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                    <h2 class="content-header-title">
                        <?php echo Labels::getLabel('LBL_VIEW_SALE_ORDER', $siteLangId); ?>
                    </h2>
                </div>
                <?php
                $orderObj = new Orders();
                $processingStatuses = $orderObj->getVendorAllowedUpdateOrderStatuses();
                $processingStatuses = array_diff($processingStatuses, [OrderStatus::ORDER_DELIVERED]);
                $canCancelOrder = in_array($orderDetail['orderstatus_id'], $processingStatuses);
                if ($canCancelOrder && $canEdit) { ?>
                    <div class="col-auto">
                        <a href="<?php echo UrlHelper::generateUrl('Seller', 'sales'); ?>" class="btn btn-outline-brand  btn-sm no-print" title="<?php echo Labels::getLabel('LBL_Back_to_order', $siteLangId); ?>">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div class="btn-group">
                            <a href="<?php echo UrlHelper::generateUrl('seller', 'cancelOrder', array($orderDetail['op_id'])); ?>" class="btn btn-outline-brand btn-sm" title="<?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?>"><?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <div class="order-number">
                            <small class="sm-txt"><?php echo Labels::getLabel('LBL_ORDER_#', $siteLangId); ?></small>
                            <span class="numbers"> <?php echo $orderDetail['op_invoice_number'] ?>
                        </div>
                    </h5>
                    <?php if (!$print) { ?>
                        <div>
                            <iframe src="<?php echo Fatutility::generateUrl('seller', 'viewOrder', $urlParts) . '/print'; ?>" name="frame" class="printFrame-js" style="display:none" width="1" height="1"></iframe>

                            <a target="_blank" href="<?php echo UrlHelper::generateUrl('Seller', 'viewInvoice', [$orderDetail['op_id']]); ?>" class="btn btn-outline-brand btn-sm no-print" title="
								<?php echo Labels::getLabel('LBL_INVOICE', $siteLangId); ?>">
                                <i class="fas fa-print"></i>
                            </a>
                            <a target="_blank" href="<?php echo UrlHelper::generateUrl('Account', 'viewBuyerOrderInvoice', [$orderDetail['order_id'], $orderDetail['op_id']]); ?>" class="btn btn-outline-brand btn-sm no-print" title="<?php echo Labels::getLabel('LBL_BUYER_INVOICE', $siteLangId); ?>">
                                <i class="fas fa-print"></i>
                            </a>
                            <?php

                            if (!in_array($orderDetail['op_status_id'], unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS"))) && $orderDetail['opshipping_fulfillment_type'] == Shipping::FULFILMENT_SHIP && $shippedBySeller && is_object($shippingApiObj) && ('CashOnDelivery' == $orderDetail['plugin_code'] || Orders::ORDER_PAYMENT_PAID == $orderDetail['order_payment_status']) && false === OrderCancelRequest::getCancelRequestById($orderDetail['op_id'])) {

                                $opId = $orderDetail['op_id'];
                                if (1 < $orderDetail['opshipping_rate_id'] && (empty($orderDetail['opshipping_plugin_id']) || ($shippingApiObj->getKey('plugin_id') != $orderDetail['opshipping_plugin_id'] && empty($orderDetail['opr_response'])))) {
                            ?>
                                    <a href="javascript:void(0)" onclick="shippingRatesForm(<?php echo $opId; ?>)" class="btn btn-outline-brand  btn-sm no-print" title="<?php echo Labels::getLabel('LBL_FETCH_SHIPPING_RATES', $siteLangId); ?>"><i class="fas fa-file-invoice"></i></a>

                                    <?php
                                } else {
                                    if ($shippingApiObj->getKey('plugin_id') == $orderDetail['opshipping_plugin_id']) {
                                        if (empty($orderDetail['opr_response']) && empty($orderDetail['opship_tracking_number']) && true === $shippingApiObj->canGenerateLabelSeprately()) {
                                            $orderId = $orderDetail['order_id'];
                                    ?>
                                            <a href="javascript:void(0)" onclick='generateLabel(<?php echo $opId; ?>)' class="btn btn-outline-brand  btn-sm no-print" title="<?php echo Labels::getLabel('LBL_GENERATE_LABEL', $siteLangId); ?>"><i class="fas fa-file-download"></i></a>
                                            <?php
                                        } elseif (!empty($orderDetail['opr_response'])) {
                                            if (OrderStatus::ORDER_REFUNDED == $orderDetail["op_status_id"]) {
                                            ?>
                                                <a target="_blank" href="<?php echo UrlHelper::generateUrl("ShippingServices", 'previewReturnLabel', [$orderDetail['op_id']]); ?>" class="btn btn-outline-brand  btn-sm no-print" title="<?php echo Labels::getLabel('LBL_PREVIEW_RETURN_LABEL', $siteLangId); ?>"><i class="fas fa-file-export"></i></a>
                                            <?php } else { ?>
                                                <a target="_blank" href="<?php echo UrlHelper::generateUrl("ShippingServices", 'previewLabel', [$orderDetail['op_id']]); ?>" class="btn btn-outline-brand  btn-sm no-print" title="<?php echo Labels::getLabel('LBL_PREVIEW_LABEL', $siteLangId); ?>"><i class="fas fa-file-export"></i></a>
                                            <?php } ?>
                                        <?php
                                        }

                                        if (
                                            (!empty($orderStatus) && 'awaiting_shipment' == $orderStatus && !empty($orderDetail['opr_response'])) ||
                                            (false === $shippingApiObj->canGenerateLabelSeprately() && empty($orderDetail['opship_order_number']))
                                        ) {
                                            if (true === $shippingApiObj->canGenerateLabelFromShipment()) {
                                                $label = Labels::getLabel('LBL_BUY_SHIPMENT_&_GENERATE_LABEL', $siteLangId);
                                            } else {
                                                $label = Labels::getLabel('LBL_BUY_SHIPMENT', $siteLangId);
                                            }
                                        ?>
                                            <a href="javascript:void(0)" onclick="proceedToShipment(<?php echo $opId; ?>)" class="btn btn-outline-brand  btn-sm no-print" title="<?php echo $label; ?>"><i class="fas fa-shipping-fast"></i></a>
                                        <?php
                                        }

                                        if ($orderDetail['orderstatus_id'] == OrderStatus::ORDER_SHIPPED && true === $shippingApiObj->canCreatePickup()) {
                                        ?>
                                            <?php
                                            $pickUpDetails =  OrderProduct::getPickUpShedule($opId);
                                            if (!$pickUpDetails || 1 > $pickUpDetails['opsp_scheduled']) {
                                            ?>
                                                <a href="javascript:void(0)" onclick="getPickupForm(<?php echo $opId; ?>)" class="btn btn-outline-brand  btn-sm no-print" title="<?php echo Labels::getLabel('LBL_CREATE_PICKUP', $siteLangId); ?>">
                                                    <i class="fas fa-truck-pickup"></i>
                                                </a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0)" onclick="cancelPickup(<?php echo $opId; ?>)" class="btn btn-outline-brand  btn-sm no-print" title="<?php echo Labels::getLabel('LBL_CANCEL_PICKUP', $siteLangId); ?>">
                                                    <i class="far fa-times-circle"></i>
                                                </a>
                                            <?php } ?>
                            <?php }
                                    }
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <?php
                        $this->includeTemplate('_partial/order/right-side-block.php', $this->variables, false); 

                        $data = $this->variables + [
                            'canViewShippingCharges' => true,
                            'canViewTaxCharges' => true,
                            'childOrderDetail' => $orderDetail
                        ];
                        $this->includeTemplate('_partial/order/left-side-block.php', $data, false); 
                        ?>
                        
                    </div>

                    <div class="row">
                        <?php if ($canEdit && $displayForm && !$print) { ?>
                            <div class="col-md-12 section--repeated no-print">
                                <h5><?php echo Labels::getLabel('LBL_Comments_on_order', $siteLangId); ?></h5>
                                <?php
                                $frm->setFormTagAttribute('onsubmit', 'updateStatus(this); return(false);');
                                $frm->setFormTagAttribute('class', 'form markAsShipped-js');
                                $frm->developerTags['colClassPrefix'] = 'col-md-';
                                $frm->developerTags['fld_default_col'] = 12;

                                $manualFld = $frm->getField('manual_shipping');

                                $fld = $frm->getField('op_status_id');
                                if (null != $fld) {
                                    $fld->developerTags['col'] = (null != $manualFld) ? 4 : 6;
                                }

                                $statusFld = $frm->getField('op_status_id');
                                $statusFld->setFieldTagAttribute('class', 'status-js fieldsVisibility-js');

                                $fld1 = $frm->getField('customer_notified');
                                $fld1->setFieldTagAttribute('class', 'notifyCustomer-js');
                                $fld1->developerTags['col'] = (null != $manualFld) ? 4 : 6;


                                if (null != $manualFld) {
                                    $manualFld->setFieldTagAttribute('class', 'manualShipping-js fieldsVisibility-js');
                                    $manualFld->developerTags['col'] = 4;

                                    $fld = $frm->getField('tracking_number');
                                    $fld->developerTags['col'] = 4;

                                    $fld = $frm->getField('opship_tracking_url');
                                    $courierFld = $frm->getField('oshistory_courier');
                                    if (null != $fld) {
                                        $fld->developerTags['col'] = 4;
                                        $fld->setWrapperAttribute('class', 'trackingUrlBlk--js');
                                        $fld->setFieldTagAttribute('class', 'trackingUrlFld--js');
                                        if (null != $courierFld) {
                                            $fld->htmlAfterField = '<a href="javascript:void(0)" onclick="courierFld()" class="link"><small>' . Labels::getLabel(
                                                'LBL_OR_SELECT_COURIER_?',
                                                $siteLangId
                                            ) . '</small></a>';
                                        }
                                    }

                                    if (null != $courierFld) {
                                        $courierFld->developerTags['col'] = 4;
                                        $courierFld->setWrapperAttribute('class', 'courierBlk--js d-none');
                                        $courierFld->setFieldTagAttribute('class', 'courierFld--js');
                                        $courierFld->htmlAfterField = '<a href="javascript:void(0)" onclick="trackingUrlFld()" class="link"><small>' . Labels::getLabel(
                                            'LBL_OR_TRACK_THROUGH_URL_?',
                                            $siteLangId
                                        ) . '</small></a>';
                                    }
                                }

                                $fldBtn = $frm->getField('btn_submit');
                                $fldBtn->setFieldTagAttribute('class', 'btn btn-brand');
                                $fldBtn->developerTags['col'] = 6;
                                echo $frm->getFormHtml(); ?>
                            </div>
                        <?php } ?>
                        <span class="gap"></span>
                        <?php if (true === $canAttachMoreFiles) { ?>
                            <span class="gap"></span>
                            <div class="col-md-12 section--repeated no-print">
                                <h5><?php echo Labels::getLabel('LBL_Add_more_attachments', $siteLangId); ?></h5>
                                <?php
                                $moreAttachmentsFrm->setFormTagAttribute('class', 'form');
                                $moreAttachmentsFrm->setFormTagAttribute('id', 'additional_attachments');
                                $fld = $moreAttachmentsFrm->getField('downloadable_file');
                                $fld->setFieldTagAttribute('onchange', 'uploadAdditionalAttachment(this); return false;');
                                echo $moreAttachmentsFrm->getFormHtml();
                                ?>
                            </div>
                        <?php } ?>
                        <span class="gap"></span>
                        <?php if (!empty($digitalDownloads)) { ?>
                            <div class="col-md-12 section--repeated js-scrollable table-wrap">
                                <h5><?php echo Labels::getLabel('LBL_Downloads', $siteLangId); ?></h5>
                                <table class="table table-justified table--orders">
                                    <tbody>
                                        <tr class="">
                                            <th><?php echo Labels::getLabel('LBL_#', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_File', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Language', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Download_times', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Downloaded_count', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Expired_on', $siteLangId); ?></th>
                                            <?php if ($canEdit) { ?>
                                                <th></th>
                                            <?php } ?>
                                        </tr>
                                        <?php $sr_no = 1;
                                        foreach ($digitalDownloads as $key => $row) {
                                            $lang_name = Labels::getLabel('LBL_All', $siteLangId);
                                            if ($row['afile_lang_id'] > 0) {
                                                $lang_name = $languages[$row['afile_lang_id']];
                                            }

                                            $fileName = '<a href="' . UrlHelper::generateUrl('Seller', 'downloadOpAttachment', array($row['afile_id'], $row['afile_record_id'], AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD)) . '">' . $row['afile_name'] . '</a>';
                                            $downloads = '<li><a href="' . UrlHelper::generateUrl('Seller', 'downloadOpAttachment', array($row['afile_id'], $row['afile_record_id'], AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD)) . '"><i class="fa fa-download"></i></a></li>';

                                            $expiry = Labels::getLabel('LBL_N/A', $siteLangId);
                                            if ($row['expiry_date'] != '') {
                                                $expiry = FatDate::Format($row['expiry_date']);
                                            }

                                            $downloadableCount = Labels::getLabel('LBL_N/A', $siteLangId);
                                            if ($row['downloadable_count'] != -1) {
                                                $downloadableCount = $row['downloadable_count'];
                                            } ?>
                                            <tr>
                                                <td><?php echo $sr_no; ?></td>
                                                <td><?php echo '<div class="text-break">' . $fileName . '</div>'; ?></td>
                                                <td><?php echo $lang_name; ?></td>
                                                <td><?php echo $downloadableCount; ?></td>
                                                <td><?php echo $row['afile_downloaded_times']; ?></td>
                                                <td><?php echo $expiry; ?></td>
                                                <td>
                                                    <ul class="actions"><?php echo ($canEdit) ? $downloads : ''; ?></ul>
                                                </td>
                                            </tr>
                                        <?php $sr_no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>

                        <span class="gap"></span>
                        <?php if (!empty($digitalDownloadLinks)) { ?>
                            <div class="col-md-12 section--repeated js-scrollable table-wrap">
                                <h5><?php echo Labels::getLabel('LBL_Downloads', $siteLangId); ?></h5>
                                <table class="table  table--orders">
                                    <tbody>
                                        <tr class="">
                                            <th><?php echo Labels::getLabel('LBL_#', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Link', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Download_times', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Downloaded_count', $siteLangId); ?></th>
                                            <th><?php echo Labels::getLabel('LBL_Expired_on', $siteLangId); ?></th>
                                        </tr>
                                        <?php $sr_no = 1;
                                        foreach ($digitalDownloadLinks as $key => $row) {
                                            $expiry = Labels::getLabel('LBL_N/A', $siteLangId);
                                            if ($row['expiry_date'] != '') {
                                                $expiry = FatDate::Format($row['expiry_date']);
                                            }

                                            $downloadableCount = Labels::getLabel('LBL_N/A', $siteLangId);
                                            if ($row['downloadable_count'] != -1) {
                                                $downloadableCount = $row['downloadable_count'];
                                            } ?>
                                            <tr>
                                                <td><?php echo $sr_no; ?></td>
                                                <td>
                                                    <div class="text-break"><a target="_blank" href="<?php echo $row['opddl_downloadable_link']; ?>" title="<?php echo Labels::getLabel('LBL_Click_to_download', $siteLangId); ?>"><?php echo $row['opddl_downloadable_link']; ?></a></div>
                                                </td>
                                                <td><?php echo $downloadableCount; ?></td>
                                                <td><?php echo $row['opddl_downloaded_times']; ?></td>
                                                <td><?php echo $expiry; ?></td>
                                            </tr>
                                        <?php $sr_no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>`
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
    var canShipByPlugin = <?php echo (!empty($shippingApiObj) ? 1 : 0); ?>;
    var orderShippedStatus = <?php echo OrderStatus::ORDER_SHIPPED; ?>;
</script>