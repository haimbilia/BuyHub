<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frmSearch->getField('lang_id')->addFieldTagAttribute('id', '');

$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $title = Labels::getLabel('LBL_Product_Tags', $siteLangId);
    $data = [
        'headingLabel' =>  $title . '<i class="fa fa-info-circle" data-bs-toggle="tooltip" data-placement="right" title="' . Labels::getLabel('LBL_Tags_can_only_be_added_for_private_products', $siteLangId) . '"></i>',
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-table">
                        <?php if (1 < count($languages)) { ?>
                            <div class="row justify-content-end m-4">
                                <div class="col-auto">
                                    <select class="form-control form-select" onchange="langForm(this)" name="lang_id">
                                        <?php foreach ($languages as $langId => $langName) {
                                            echo "<option value='$langId'>$langName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        <div id="listing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>