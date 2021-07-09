<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$otherTabsData = isset($otherTabsData) && is_array($otherTabsData) ? $otherTabsData : [];
$otherButtons = isset($otherButtons) && is_array($otherButtons) ? $otherButtons : [];

$pagesTabsData = ([
    'siteLangId' => $siteLangId,
    'controllerName' => $controllerName,
    'action' => $action,
    'canEdit' => $canEdit,
    'otherButtons' => $otherButtons,
] + $otherTabsData);

$actionButtons = isset($data) && is_array($data) ? $data : [];

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <h2 class="content-header-title"><?php echo $headingLabel; ?></h2>
            </div>
            <?php $this->includeTemplate('_partial/productPagesTabs.php', $pagesTabsData, false); ?>
        </div>
        <div class="content-body pagebody--js">
            <div id="otherTopForm--js"></div>
            <?php if (!empty($frmSearch)) { ?>
                <div class="row mb-4 searchform_filter">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="replaced">
                                    <?php echo $frmSearch->getFormHtml(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div id="otherMidForm--js"></div>
            <div class="row listingSection--js">
                <div class="col-lg-12">
                    <div class="card">
                        <?php if (!empty($actionButtons)) { ?>
                            <div class="card-header">
                                <div class="card-title"></div>
                                <?php $this->includeTemplate('_partial/action-buttons.php', $actionButtons, false); ?>
                            </div>
                        <?php } ?>
                        <div class="card-body">
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="editRecord--js"></span>
    </div>
</main>