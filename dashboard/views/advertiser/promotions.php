<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_PROMOTIONS', $siteLangId),
        'siteLangId' => $siteLangId,
    ];
    if ($canEdit) {
        $data['otherButtons'][] = [
            'attr' => [
                'onclick' => 'promotionForm()',
                'class' => 'btn btn-outline-gray btn-icon',
                'title' => Labels::getLabel('LBL_ADD_PROMOTION', $siteLangId)
            ],
            'icon' => '<svg class="svg btn-icon-start" width="18" height="18">
            <use xlink:href="' . CONF_WEBROOT_URL . '/images/retina/sprite-actions.svg#add">
            </use>
        </svg>',
            'label' => Labels::getLabel('LBL_NEW', $siteLangId)
        ];
    }

    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-md-12">
                <div class="info p-3">
                    <span>
                        <svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                            </use>
                        </svg><?php echo Labels::getLabel('MSG_Minimum_balance_Required_For_Promotions', $siteLangId) . ' : ' . CommonHelper::displaymoneyformat(FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE')); ?>
                    </span>
                </div>
            </div>
        </div>
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