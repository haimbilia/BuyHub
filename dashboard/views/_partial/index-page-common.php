<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$otherTabsData = isset($otherTabsData) && is_array($otherTabsData) ? $otherTabsData : [];
$otherButtons = isset($otherButtons) && is_array($otherButtons) ? $otherButtons : [];
$listingLabel = isset($listingLabel) ? $listingLabel : "";
$pagesTabsData = ([
    'siteLangId' => $siteLangId,
    'controllerName' => $controllerName,
    'action' => $action,
    'canEdit' => $canEdit,
    'otherButtons' => $otherButtons,
    'headingLabel' => $headingLabel,
] + $otherTabsData);

$actionButtons = isset($data) && is_array($data) ? $data : [];

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php $this->includeTemplate('_partial/header/content-header.php', $pagesTabsData, false); ?>
        <div class="content-body pagebody--js">
            <div id="otherTopForm--js"></div>
            <?php if (!empty($frmSearch)) { ?>
                <div class="row mb-4 searchform_filter">
                    <div class="col-lg-12">
                        <div class="card card-search">
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
                                <div class="card-title"><?php echo $listingLabel; ?></div>
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