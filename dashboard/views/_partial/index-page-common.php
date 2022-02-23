<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$otherTabsData = isset($otherTabsData) && is_array($otherTabsData) ? $otherTabsData : [];
$newRecordBtn = $newRecordBtn ?? false;
$newRecordBtnAttrs = $newRecordBtnAttrs ?? [];
$otherButtons = isset($otherButtons) && is_array($otherButtons) ? $otherButtons : [];
$listingLabel = isset($listingLabel) ? $listingLabel : "";
$headingBackButton = $headingBackButton ?? false;
$pagesTabsData = ([
    'siteLangId' => $siteLangId,
    'controllerName' => $controllerName,
    'action' => $action,
    'canEdit' => $canEdit,
    'otherButtons' => $otherButtons,
    'headingLabel' => $headingLabel,
    'newRecordBtn' => $newRecordBtn,
    'newRecordBtnAttrs' => $newRecordBtnAttrs,
    'headingBackButton' => $headingBackButton,
] + $otherTabsData);

$actionButtons = isset($data) && is_array($data) ? $data : [];

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php $this->includeTemplate('_partial/header/content-header.php', $pagesTabsData, false); ?>
    <div class="content-body pagebody--js">
        <div id="otherTopForm--js"></div>
        <div class="row listingSection--js">
            <div class="col-lg-12">
                <div class="card">
                    <?php
                    if (!empty($frmSearch)) {
                        require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');
                    } ?>
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