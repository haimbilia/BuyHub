<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$dateFromFld = $frmSearch->getField('date_from');
$dateFromFld->setFieldTagAttribute('class', 'field--calender');

$dateToFld = $frmSearch->getField('date_to');
$dateToFld->setFieldTagAttribute('class', 'field--calender');

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Orders', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');; ?>
                    <div class="card-body">
                        <div id="ordersListing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>