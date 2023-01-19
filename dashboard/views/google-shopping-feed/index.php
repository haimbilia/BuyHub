<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');
$merchantId = isset($userData[$keyName . '_merchantId']) ? $userData[$keyName . '_merchantId'] : '';
$serviceAccInfo = isset($userData['service_account']) ? $userData['service_account'] : '';
?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' =>  $pluginName,
        'siteLangId' => $siteLangId
    ];

    if (!empty($merchantId) && !empty($serviceAccInfo)) {
        $data['newRecordBtn'] = true;
        $data['newRecordBtnAttrs'] = [
            'attr' => [
                'onclick' => 'batchForm(0)',
                'title' => Labels::getLabel('BTN_NEW_BATCH', $siteLangId)
            ],
        ];
    }
    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="row ">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h6 class="m-0">
                            <?php if (empty($merchantId) && $userPrivilege->canEditAdvertisementFeed(UserAuthentication::getLoggedUserId(), true)) { ?>
                                <?php echo Labels::getLabel('Lbl_SETUP_MERCHANT_ACCOUNT', $siteLangId); ?>
                                <a class="buttons-list-link" href="<?php echo UrlHelper::generateUrl($keyName, 'getAccessToken'); ?>">
                                    <span class="buttons-list-wrap"> <span class="buttons-list-icon">
                                            <img class="svg" width="42" height="42" alt="" src="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/social-icons/GoogleLogin.svg">
                                        </span>
                                        <?php echo Labels::getLabel('LBL_SIGN_IN_WITH_GOOGLE', $siteLangId); ?>
                                    </span>
                                </a>
                            <?php } else {
                                echo Labels::getLabel('Lbl_MERCHANT_ID', $siteLangId) . ':' . $merchantId;
                            }

                            if (empty($merchantId) && !$userPrivilege->canEditAdvertisementFeed(UserAuthentication::getLoggedUserId(), true)) {
                                echo Labels::getLabel('LBL_YOU_ARE_NOT_ALLOWED_TO_SETUP_ACCOUNT', $siteLangId);
                            }
                            ?>
                        </h6>
                        <?php if (!empty($merchantId) && $userPrivilege->canEditAdvertisementFeed(UserAuthentication::getLoggedUserId(), true)) { ?>
                            <a class="btn btn-brand btn-sm" href="javascript:void(0)" onclick="serviceAccountForm();" id="userAccInfoBtn"><?php echo Labels::getLabel('Lbl_SERVICE_ACCOUNT_INFO', $siteLangId); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($merchantId) && !empty($serviceAccInfo)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <?php
                        if (!empty($frmSearch)) {
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');
                        } ?>
                        <div class="card-table" id="listing">
                            <div class="container m-2"><?php echo Labels::getLabel('LBL_LOADING..', $siteLangId); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<?php if (!empty($merchantId) && empty($serviceAccInfo) && $userPrivilege->canEditAdvertisementFeed(UserAuthentication::getLoggedUserId(), true)) { ?>
    <script>
        $(document).ready(function() {
            serviceAccountForm();
        });
    </script>
<?php }
