<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frmSearch->getField('lang_id')->addFieldTagAttribute('id','');

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Product_Tags', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                    <?php if(1 < count($languages)) {?>
                                <div class="content-header-toolbar">
                                    <div class="input-group">
                                        <select class="form-control form-select" onchange="langForm(this)"  name="lang_id">
                                            <?php foreach($languages as $langId => $langName){
                                                $selectedClass = $langFld->value == $langId ? 'selected':'';
                                                echo "<option value='$langId' $selectedClass>$langName</option>";
                                            }
                                        ?>
                                        </select>            
                                </div>
                            <?php } ?>
                        <div id="ordersListing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

