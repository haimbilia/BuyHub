<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('class', 'form');

$keywordFld = $frmSearch->getField('keyword');
if (0 < $selProd_id) {
    $keywordFld->setFieldTagAttribute('readonly', 'readonly');
} ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_SELLER_PRODUCTS_VOLUME_DISCOUNT', $siteLangId),
        'siteLangId' => $siteLangId,
        'newRecordBtn' => true
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="content-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                        <div class="card-body">
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>