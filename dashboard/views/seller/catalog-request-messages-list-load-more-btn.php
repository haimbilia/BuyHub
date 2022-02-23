<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$nextPage = $page + 1;
if ($nextPage <= $pageCount) { ?>
    <a id="loadMoreBtn" href="javascript:void(0)" onclick="goToCatalogRequestMessageSearchPage(<?php echo $nextPage; ?>);" class="btn btn-outline-gray loadmore">Load Previous Messages</a>
<?php
}
?>