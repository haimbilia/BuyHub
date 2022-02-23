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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div id="ordersListing"></div>
                        <span class="gap"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>