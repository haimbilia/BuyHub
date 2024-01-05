<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$page = $page ?? 1;
if ($pageCount > $page) { ?>
    <div class="last-row lastRowJs">
        <button class="btn btn-brand btn-load-more" onclick="loadmore(<?php echo $primaryOfferId; ?>,  <?php echo ($page + 1) ?>); ">
            <?php echo Labels::getLabel('LBL_LOAD_PREVIOUS'); ?>
        </button>
    </div>
<?php }

$displayDate = '';
foreach ($data as $row) {
    require 'attachment-record.php';
} ?>