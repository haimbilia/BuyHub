<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$nextPage = $page + 1;
if ($nextPage <= $pageCount) {
    $searchFunction = 'goToProductListingSearchPage';
    if (isset($pagingFunc)) {
        $searchFunction =  $pagingFunc;
    }
?>
    <!--<a id="loadMoreBtn" href="javascript:void(0)" onclick="<?php echo $searchFunction . '(' . $nextPage . ')'; ?>" class="btn btn-outline-gray loadmore"><?php echo Labels::getLabel('LBL_Load_More', $siteLangId); ?></a>-->
<?php
}
?>