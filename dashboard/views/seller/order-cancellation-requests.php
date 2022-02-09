<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
$orderIdFld = $frmSearch->getField('op_invoice_number');
$orderIdFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_BY_INVOICE_NUMBER', $siteLangId));

$ocrequestDateFromFld = $frmSearch->getField('ocrequest_date_from');
$ocrequestDateFromFld->setFieldTagAttribute('class', 'field--calender');
$ocrequestDateFromFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Date_From', $siteLangId));

$ocrequestDateToFld = $frmSearch->getField('ocrequest_date_to');
$ocrequestDateToFld->setFieldTagAttribute('class', 'field--calender');
$ocrequestDateToFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Date_to', $siteLangId));

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Order_Cancellation_Requests', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div id="cancelOrderRequestsListing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>