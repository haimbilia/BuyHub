<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div class="card-foot listingPaginationJs">
    <?php
    $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array(
        'name' => 'frmRecordSearchPaging'
    ));
    if (1 < $pageCount) {
        $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
        $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
    } ?>
</div>