<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit', 'searchReport(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');

$frmSrch->setCustomRendererClass('FormRendererBS');
$frmSrch->developerTags['colWidthClassesDefault'] = ['col-lg', 'col-md-', null, null];
$frmSrch->developerTags['colWidthValuesDefault'] = [4, 4, null, null];
?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Products', $siteLangId); ?></h2>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <?php echo '<a href="javascript:void(0)" onClick="exportSalesReport()" class="btn btn-outline-brand btn-sm">' . Labels::getLabel('LBL_Export', $siteLangId) . '</a>';
                    if (!empty($orderDate)) {
                        echo '<a href="' . UrlHelper::generateUrl('Reports', 'SalesReport') . '" class="btn btn-outline-brand btn-sm">' . Labels::getLabel('LBL_Back', $siteLangId) . '</a>';
                    } ?>
                </div>
            </div>
        </div>
        <div class="content-body">

            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="replaced">
                                <?php
                                $sortBy = $frmSrch->getField('sortBy');
                                $sortBy->setFieldTagAttribute('id', 'sortBy');

                                $sortOrder = $frmSrch->getField('sortOrder');
                                $sortOrder->setFieldTagAttribute('id', 'sortOrder');

                                $submitFld = $frmSrch->getField('btn_submit');
                                $submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');
                                $submitFld->developerTags['colWidthValues'] = [null, '2', null, null];

                                $fldClear = $frmSrch->getField('btn_clear');
                                $fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
                                $fldClear->developerTags['colWidthValues'] = [null, '2', null, null];
                                echo $frmSrch->getFormHtml();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="listing-tbl" id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>