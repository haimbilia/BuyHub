<?php defined('SYSTEM_INIT') or die('Invalid Usage'); 

$defaultPageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
$doNotLimitRecords = $doNotLimitRecords ?? false; 
if (false === $doNotLimitRecords) { ?>
    <div class="listingPaginationJs">
        <?php
        $postedData['page'] = $page;
        echo FatUtility::createHiddenFormFromData($postedData, array(
            'name' => 'frmRecordSearchPaging'
        )); ?>
        <?php 
        if (1 < $pageCount || $recordCount > $defaultPageSize) { ?>
            <div class="card-foot">
                <?php
                $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'siteLangId' => (isset($langId) && 0 < $langId ? $langId : $siteLangId));
                $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
                ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>