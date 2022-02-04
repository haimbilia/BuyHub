<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' =>  Labels::getLabel('LBL_Seller_Options', $siteLangId),
        'siteLangId' => $siteLangId,
        'canEdit' => $canEdit
    ];

    if ($canEdit) {
        $data['otherButtons'] = [
            [
                'attr' => [
                    'onclick' => 'optionForm(0)',
                    'title' => Labels::getLabel('LBL_Add_Option', $siteLangId)
                ],
                'label' => Labels::getLabel('LBL_Add_Option', $siteLangId)
            ],
        ];
    }

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div id="optionListing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>