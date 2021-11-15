<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

<div class="listingPaginationJs">
    <?php
    $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array(
        'name' => 'frmRecordSearchPaging'
    )); ?>
    <?php if (1 < $pageCount) { ?>
        <div class="card-foot">
            <?php
            $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId);
            $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
            ?>
        </div>
    <?php } ?>
</div>