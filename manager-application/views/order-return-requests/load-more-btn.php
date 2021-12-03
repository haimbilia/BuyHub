<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$nextPage = $page + 1;
if ($nextPage <= $pageCount) { ?>
    <a id="loadMoreBtnJs" href="javascript:void(0);" class="btn btn-icon btn-outline-brand btn-add ml-2" onclick="goToMessageSearchPage(<?php echo $nextPage; ?>);" title="<?php echo Labels::getLabel('LBL_LOAD_PREVIOUS_MESSAGES', $siteLangId); ?>" data-toggle='tooltip' data-placement='top'>
        <?php echo Labels::getLabel('LBL_LOAD_PREVIOUS', $siteLangId); ?>
    </a>
<?php }