<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_DOWNLOADS', $siteLangId),
        'siteLangId' => $siteLangId,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card card-tabs">
            <div class="card-head">
                <nav class="nav nav-tabs navTabsJs">
                    <a class="nav-link active" href="javascript:void(0);" onclick="searchBuyerDownloads('', this)">
                        <?php echo Labels::getLabel('LBL_Downloadable_Files', $siteLangId); ?></a>
                    <a class="nav-link" href="javascript:void(0);" onclick="searchBuyerDownloadLinks('', this)">
                        <?php echo Labels::getLabel('LBL_Downloadable_Links', $siteLangId); ?></a>
                </nav>
            </div>
            <div id="listing"></div>
        </div>
    </div>
</div>