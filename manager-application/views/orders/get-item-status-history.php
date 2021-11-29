<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$totalRecords = count($arrListing); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo 0 < $totalRecords ? $arrListing[0]['op_product_name'] : Labels::getLabel('LBL_ITEM_STATUS_HISTORY', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body opStausLogJs<?php echo $opId; ?>">
    <div class="form-edit-body">
        <?php 
        if ($totalRecords == 0) {
            LibHelper::exitWithError(Labels::getLabel('MSG_NO_RECORD_FOUND', $siteLangId), false, false, true);
        } else { ?>
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