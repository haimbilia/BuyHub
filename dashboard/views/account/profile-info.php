<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main">
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
                    <div class="card">
                        <div class="card-body">
                            <?php if ($userParentId == 0) { ?>
                            <div class="tabs ">
                                <ul class="tabs-js">
                                    <li class="is-active" id="tab-myaccount">
                                        <a href="javascript:void(0);" onClick="profileInfoForm()">
                                            <?php echo Labels::getLabel('LBL_My_Account', $siteLangId); ?>
                                        </a>
                                    </li>
                                    <?php if (User::isAffiliate()) { ?>
                                    <li id="tab-paymentinfo">
                                        <a href="javascript:void(0);"
                                            onClick="affiliatePaymentInfoForm()"><?php echo Labels::getLabel('LBL_Payment_Info', $siteLangId); ?></a>
                                    </li>
                                    <?php }
                                        if (!User::isAffiliate()) { ?>
                                    <li id="tab-bankaccount">
                                        <a href="javascript:void(0);"
                                            onClick="bankInfoForm()"><?php echo Labels::getLabel('LBL_Bank_Account', $siteLangId); ?></a>
                                    </li>
                                    <?php } ?>
                                    <?php
                                        foreach ($payouts as $type => $name) { ?>
                                    <li id="tab-<?php echo $type; ?>">
                                        <a href="javascript:void(0);" onClick="pluginForm('<?php echo $type; ?>')">
                                            <?php echo $name; ?>
                                        </a>
                                    </li>
                                    <?php }
                                        if (FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1)) {
                                        ?>
                                    <li id="tab-cookies-preferences">
                                        <a href="javascript:void(0);"
                                            onClick="cookiesPreferencesForm()"><?php echo Labels::getLabel('LBL_Cookies_Preferences', $siteLangId); ?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>
                            <div id="profileInfoFrmBlock">
                                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>