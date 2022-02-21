<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-wrapper content-space">
            <?php
            $data = [
                'headingLabel' => Labels::getLabel('LBL_ACCOUNT_SETTINGS', $siteLangId),
                'siteLangId' => $siteLangId,
            ];

            if (0 == $userParentId && $showSellerActivateButton) {
                $data['otherButtons'] = array_merge($data['otherButtons'], [
                    'attr' => [
                        'href' => UrlHelper::generateUrl('Seller'),
                        'class' => 'btn-outline-brand panel__head_action',
                        'title' => Labels::getLabel('LBL_Activate_Seller_Account', $siteLangId)
                    ],
                    'label' => Labels::getLabel('LBL_Activate_Seller_Account', $siteLangId)
                ]);
            }

            $this->includeTemplate('_partial/header/content-header.php', $data); ?>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div id="profileInfoFrmBlock">
                            <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>