<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$defaultPageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
$doNotLimitRecords = $doNotLimitRecords ?? false;
$hidePaginationHtml = $hidePaginationHtml ?? false;
$pageCount = $pageCount ?? 0;
$recordCount = $recordCount ?? 0;
$page = $page ?? 0;

if (false === $doNotLimitRecords) { ?>
    <div class="listingPaginationJs">
        <?php
        $postedData['page'] = $page;
        echo FatUtility::createHiddenFormFromData($postedData, array(
            'name' => 'frmRecordSearchPaging'
        )); ?>
        <?php if (false === $hidePaginationHtml && (1 < $pageCount || $recordCount > $defaultPageSize)) { ?>
            <div class="card-foot">
                <?php
                $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'siteLangId' => (isset($langId) && 0 < $langId ? $langId : $siteLangId));
                $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
                ?>
            </div>
        <?php } else { ?>
            <div class="card-foot">
                <div class="row justify-content-between">
                    <div class="col">
                        <div class="data-length">
                            <?php
                            $str = Labels::getLabel('LBL_TOTAL_RECORDS', $siteLangId);
                            $str .= ': ' . $recordCount;
                            echo $str; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>