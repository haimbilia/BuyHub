<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php 
            $str = Labels::getLabel('LBL_{COUPON-TITLE}_HISTORY_(_{COUPON-CODE}_)', $siteLangId); 
            echo CommonHelper::replaceStringData($str, ['{COUPON-TITLE}' => $couponData['coupon_title'], '{COUPON-CODE}' => $couponData['coupon_code']])
        ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body">
        <?php 
        $totalRecords = count($arrListing);
        if ($totalRecords == 0) {
            $this->includeTemplate('_partial/no-record-found.php');
        } else { ?>
            <div class="timeline-v4 appendRowsJs">
                <?php require_once('get-rows.php'); ?>
            </div>
            <?php 
            $lastRecord = current(array_reverse($arrListing));
            $postedData['reference'] = $lastRecord['couponhistory_added_on'];
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