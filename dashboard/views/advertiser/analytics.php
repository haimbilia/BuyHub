<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Promotion_Analytics', $siteLangId) . ' - ' . $promotionDetails['promotion_name'],
        'siteLangId' => $siteLangId,
    ];

    $data['otherButtons'][] = [
        'attr' => [
            'href' => UrlHelper::generateUrl('Advertiser', 'Promotions'),
            'title' => Labels::getLabel('LBL_My_promotions', $siteLangId)
        ],
        'label' => Labels::getLabel('LBL_My_promotions', $siteLangId)
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body" id="listing">
                        <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>