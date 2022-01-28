<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php', ['isUserDashboard' => $isUserDashboard]); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_ACCOUNT_SETTINGS', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    if (0 == $userParentId) {
        $data['otherButtons'] = [
            [
                'attr' => [
                    'onclick' => 'truncateDataRequestPopup()',
                    'class' => 'btn-outline-brand',
                    'title' => Labels::getLabel('LBL_Request_to_remove_my_data', $siteLangId)
                ],
                'label' => Labels::getLabel('LBL_Request_to_remove_my_data', $siteLangId)
            ],
            [
                'attr' => [
                    'onclick' => 'requestData()',
                    'class' => 'btn-outline-brand',
                    'title' => Labels::getLabel('LBL_Request_My_Data', $siteLangId)
                ],
                'label' => Labels::getLabel('LBL_Request_My_Data', $siteLangId)
            ],
        ];
        if ($showSellerActivateButton) {
            $data['otherButtons'] = array_merge($data['otherButtons'], [
                'attr' => [
                    'href' => UrlHelper::generateUrl('Seller'),
                    'class' => 'btn-outline-brand panel__head_action',
                    'title' => Labels::getLabel('LBL_Activate_Seller_Account', $siteLangId)
                ],
                'label' => Labels::getLabel('LBL_Activate_Seller_Account', $siteLangId)
            ]);
        }
    }

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-tabs">
                    <div class="card-head"> <?php if ($userParentId == 0) { ?>
                            <nav class="nav nav-tabs">

                                <a class="nav-link active" id="tab-myaccount" href="javascript:void(0);" onClick="profileInfoForm()">
                                    <?php echo Labels::getLabel('LBL_My_Account', $siteLangId); ?>
                                </a>

                                <?php if (User::isAffiliate()) { ?>

                                    <a class="nav-link" id="tab-paymentinfo" href="javascript:void(0);" onClick="affiliatePaymentInfoForm()"><?php echo Labels::getLabel('LBL_Payment_Info', $siteLangId); ?></a>

                                <?php }
                                                if (!User::isAffiliate()) { ?>

                                    <a class="nav-link" id="tab-bankaccount" href="javascript:void(0);" onClick="bankInfoForm()"><?php echo Labels::getLabel('LBL_Bank_Account', $siteLangId); ?></a>

                                <?php } ?>
                                <?php
                                                foreach ($payouts as $type => $name) { ?>

                                    <a class="nav-link" id="tab-<?php echo $type; ?>" href="javascript:void(0);" onClick="pluginForm('<?php echo $type; ?>')">
                                        <?php echo $name; ?>
                                    </a>

                                <?php }
                                                if (FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1)) {
                                ?>

                                    <a class="nav-link" id="tab-cookies-preferences" href="javascript:void(0);" onClick="cookiesPreferencesForm()"><?php echo Labels::getLabel('LBL_Cookies_Preferences', $siteLangId); ?></a>

                                <?php } ?>

                            </nav>
                        <?php } ?>
                    </div>
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