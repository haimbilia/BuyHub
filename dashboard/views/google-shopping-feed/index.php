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

    $canEditAdvFeed = $userPrivilege->canEditAdvertisementFeed(UserAuthentication::getLoggedUserId(), true);
    if ($canEditAdvFeed) {
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
                    <div class="card-head">
                        <h5 class="card-title">
                            <?php if ($canEditAdvFeed) {
                                if (!empty($merchantId)) {
                                    echo Labels::getLabel('Lbl_MERCHANT_ID', $siteLangId) . ': ';
                            ?>
                                    <span class="badge bg-light text-dark"><?php echo $merchantId; ?></span>
                                <?php
                                } else {
                                    echo Labels::getLabel('Lbl_SETUP_MERCHANT_ACCOUNT', $siteLangId);
                                } ?>
                            <?php } else {
                                echo Labels::getLabel('LBL_YOU_ARE_NOT_ALLOWED_TO_SETUP_ACCOUNT', $siteLangId);
                            } ?>
                        </h5>
                        <?php
                        if ($canEditAdvFeed) { ?>
                            <div class="card-head-toolbar">
                                <?php if (empty($merchantId)) { ?>
                                    <a class="btn btn-outline-gray btn-icon" href="<?php echo UrlHelper::generateUrl($keyName, 'getAccessToken'); ?>">
                                        <img class="svg" width="24" height="24" alt="" src="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/social-icons/GoogleLogin.svg">
                                        <?php echo Labels::getLabel('LBL_SIGN_IN_WITH_GOOGLE', $siteLangId); ?>
                                    </a>
                                <?php } else { ?>
                                    <a class="btn btn-gray" href="javascript:void(0)" onclick="serviceAccountForm();" id="userAccInfoBtn">
                                        <?php echo Labels::getLabel('Lbl_SERVICE_ACCOUNT_INFO', $siteLangId); ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
</div>


<?php if (!empty($merchantId) && empty($serviceAccInfo) && $userPrivilege->canEditAdvertisementFeed(UserAuthentication::getLoggedUserId(), true)) { ?>
    <script>
        $(document).ready(function() {
            serviceAccountForm();
        });
    </script>
<?php }
