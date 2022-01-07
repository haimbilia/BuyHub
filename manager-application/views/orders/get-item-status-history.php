<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$totalRecords = count($arrListing); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo 0 < $totalRecords ? $arrListing[0]['op_product_name'] : Labels::getLabel('LBL_ITEM_STATUS_HISTORY', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body opStausLogJs<?php echo $recordId; ?>">
    <div class="form-edit-body loaderContainerJs">
        <?php 
        if ($totalRecords == 0) {
            echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('ERR_NO_RECORD_FOUND', $siteLangId));
        } else {   
            
            $orderDetail = current($arrListing);
            $shippedBySeller = applicationConstants::NO;
            if (CommonHelper::canAvailShippingChargesBySeller($orderDetail['op_selprod_user_id'], $orderDetail['opshipping_by_seller_user_id'])) {
                $shippedBySeller = applicationConstants::YES;
            }           
            $shippingApiObj = (new Shipping($siteLangId))->getShippingApiObj(($shippedBySeller ? $orderDetail['opshipping_by_seller_user_id'] : 0)) ?? NULL;
  
            ?>
            <div class="timeline-v4 appendRowsJs">
                <?php require_once('get-rows.php'); ?>
            </div>
            <?php 
            $lastRecord = current(array_reverse($arrListing));
            $postedData['reference'] = $lastRecord['oshistory_date_added'];
            $postedData['order_id'] = $lastRecord['op_order_id'];
            $data = [
                'siteLangId' => $siteLangId,
                'postedData' => $postedData,
                'page' => $page,
                'pageCount' => $pageCount,
            ];
            $this->includeTemplate('_partial/load-more-pagination.php', $data);
        } ?>
    </div>
</div>