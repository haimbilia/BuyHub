<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearchCustomProduct->setFormTagAttribute('onsubmit', 'searchCustomProducts(this); return(false);');
$frmSearchCustomProduct->setFormTagAttribute('class', 'form');
$frmSearchCustomProduct->developerTags['colClassPrefix'] = 'col-md-';
$frmSearchCustomProduct->developerTags['fld_default_col'] = 12;

$keyFld = $frmSearchCustomProduct->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class', 'col-sm-6');
$keyFld->developerTags['col'] = 8;

$submitBtnFld = $frmSearchCustomProduct->getField('btn_submit');
$submitBtnFld->value = Labels::getLabel('LBL_Search', $siteLangId);
$submitBtnFld->setFieldTagAttribute('class', 'btn-block');
$submitBtnFld->setWrapperAttribute('class', 'col-sm-3');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmSearchCustomProduct->getField('btn_clear');
$cancelBtnFld->value = Labels::getLabel("LBL_Clear", $siteLangId);
$cancelBtnFld->setFieldTagAttribute('class', 'btn-block');
$cancelBtnFld->setWrapperAttribute('class', 'col-sm-3');
$cancelBtnFld->developerTags['col'] = 2;
?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_My_Product', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="card">
            <div class="card-head">
                <div class="card-head-label">
                    <h5 class="card-title"><?php echo Labels::getLabel('LBL_My_Products_list', $siteLangId); ?></h5>
                </div>
                <div class="action">
                    <div class="">
                        <a href="javascript:void(0)" onclick="addCatalogPopup()" class="btn btn-brand btn-sm"><?php echo Labels::getLabel('LBL_Add_New_Product', $siteLangId); ?></a>
                        <a href="<?php echo UrlHelper::generateUrl('seller', 'catalog'); ?>" class="btn btn-outline-gray btn-sm"><?php echo Labels::getLabel('LBL_Products_List', $siteLangId); ?></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php echo $frmSearchCustomProduct->getFormHtml(); ?>
                <?php echo $frmSearchCustomProduct->getExternalJS(); ?>
                <div id="listing">
                    <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                </div>
            </div>
        </div>
    </div>
</div>