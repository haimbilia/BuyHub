<?php defined('SYSTEM_INIT') or die('Invalid Usage');
/** 
** Wrapper Element must have class "appendRowsJs".
** Every Row must have class "rowJs".
** Class Method Named as "getRows".
** Class Method Must Return HTML.
** You Can Set 'data-reference' to each row having "rowJs" class if you want to carry any reference string with pagination form.
***/
if (1 < $pageCount) { ?>
    <div class="row justify-content-center loadMorePaginationJs">
        <div class="col-auto">
            <?php 
            $postedData['page'] = $page;
            $postedData['pageCount'] = $pageCount;
            echo FatUtility::createHiddenFormFromData($postedData, array(
                'name' => 'frmLoadMoreRecordsPaging'
            )); ?>
            <button class='btn btn-light btn--sm loadMoreBtnJs' href="javascript:void(0);" onclick="loadMore();"><?php echo Labels::getLabel('MSG_LOAD_MORE', $siteLangId); ?></button>
        </div>
    </div>
<?php } ?>