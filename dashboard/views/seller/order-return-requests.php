<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$orrequestDateFromFld = $frmSearch->getField('orrequest_date_from');
$orrequestDateFromFld->setFieldTagAttribute('class', 'field--calender');
$orrequestDateFromFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Date_From', $siteLangId));

$orrequestDateToFld = $frmSearch->getField('orrequest_date_to');
$orrequestDateToFld->setFieldTagAttribute('class', 'field--calender');
$orrequestDateToFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Date_to', $siteLangId));

$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Order_Return_Requests', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div id="returnOrderRequestsListing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>