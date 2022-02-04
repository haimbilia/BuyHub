<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
// $frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->setFormTagAttribute('onsubmit', 'searchCatalogProducts(this); return(false);');
/* $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 4;

$keywordFld = $frmSearch->getField('keyword');
$keywordFld->setWrapperAttribute('class', 'col-lg-4');
$keywordFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Products', $siteLangId));
$keywordFld->developerTags['col'] = 4;
$keywordFld->developerTags['noCaptionTag'] = true;

$submitFld = $frmSearch->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');

$clearFld = $frmSearch->getField('btn_clear');
$clearFld->setFieldTagAttribute('onclick', 'clearSearch()');
$clearFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block'); */

$langFld = $frmSearch->getField('lang_id');
$langFld->setFieldTagAttribute('id', 'tagLangId');
?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $title = Labels::getLabel('LBL_Product_Tags', $siteLangId);
    $data = [
        'headingLabel' => $title . '<i class="fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="' . Labels::getLabel('LBL_Tags_can_only_be_added_for_private_products', $siteLangId) . '"></i>',
        'siteLangId' => $siteLangId,
        'controllerName' => $controllerName,
        'action' => $action,
        'canEdit' => $canEdit,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <?php if (1 < count($languages)) { ?>
                            <div class="content-header-toolbar">
                                <div class="input-group">
                                    <select class="form-control form-select" onchange="langForm(this)" name="lang_id">
                                        <?php foreach ($languages as $langId => $langName) {
                                            $selectedClass = $langFld->value == $langId ? 'selected' : '';
                                            echo "<option value='$langId' $selectedClass>$langName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>
                            </div>
                            <div id="listing"><?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>