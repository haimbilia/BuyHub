<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$dateFromFld = $frmSearch->getField('date_from');
$dateFromFld->setFieldTagAttribute('class', 'field--calender');

$dateToFld = $frmSearch->getField('date_to');
$dateToFld->setFieldTagAttribute('class', 'field--calender');
?> <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_MY_ORDERS', $siteLangId),
        'siteLangId' => $siteLangId,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card">
            <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
            <div class="card-table">
                <div id="ordersListing"></div>
            </div>
        </div>
    </div>
</div>