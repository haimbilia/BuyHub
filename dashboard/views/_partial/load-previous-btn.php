<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$nextPage = $page + 1;
if ($nextPage <= $pageCount) { ?>
    <a id="loadMoreBtn" href="javascript:void(0)" onclick="goToLoadPrevious(<?php echo $nextPage; ?>);" class="btn btn-outline-gray loadmore" title="<?php echo Labels::getLabel('LBL_Load_Previous', $siteLangId); ?>"><?php echo Labels::getLabel('LBL_Load_Previous', $siteLangId); ?></a>
<?php
}
?>