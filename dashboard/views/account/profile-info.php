<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
                    <?php if (0 == $loggedUserInfo['credential_verified']) { ?>
                        <div class="card-head badge badge-info">
                            <?php
                            $title = Labels::getLabel('LBL_CLICK_HERE_TO_SEND_VERIFICATION_LINK', $siteLangId);
                            $lbl = Labels::getLabel('LBL_PLEASE_VERIFY_YOUR_EMAIL_TO_{ACTIVATE}_YOUR_ACCOUNT.', $siteLangId);
                            $htm = '<a href="javascript:void(0);" class="link-underline" onclick="guestActivate()" data-bs-toggle="tooltip" title="' . $title . '">' . Labels::getLabel('LBL_ACTIVATE', $siteLangId) . '</a>';
                            echo CommonHelper::replaceStringData($lbl, ['{ACTIVATE}' => $htm]);
                            ?>
                        </div>
                    <?php } else if (0 == $loggedUserInfo['credential_active']) { ?>
                        <div class="card-head badge badge-info">
                            <?php
                            $title = Labels::getLabel('LBL_IGNORE_IF_ALREADY_UPDATED', $siteLangId);
                            $lbl = Labels::getLabel('LBL_YOUR_ACCOUNT_YET_TO_BE_VERIFY_BY_THE_SITE_ADMIN,_TILL_THEN_UPDATE_YOUR_{PASSWORD}', $siteLangId);
                            $htm = '<a href="' . UrlHelper::generateUrl('Account', 'changeEmailPassword', [], CONF_WEBROOT_DASHBOARD) . '" class="link-underline" data-bs-toggle="tooltip" title="' . $title . '">' . Labels::getLabel('LBL_PASSWORD', $siteLangId) . '</a>';
                            echo CommonHelper::replaceStringData($lbl, ['{PASSWORD}' => $htm]);
                            ?>
                        </div>
                    <?php } else if (UserAuthentication::isGuestUserLogged()) { ?>
                        <div class="card-head badge badge-info">
                            <?php
                            $title = Labels::getLabel('LBL_IGNORE_IF_ALREADY_UPDATED', $siteLangId);
                            $lbl = Labels::getLabel('LBL_PLEASE_UPDATE_YOUR_{PASSWORD}._PLEASE_LOG_IN_AGAIN_TO_REFRESH_YOUR_SESSION_IF_PASSWORD_UPDATED', $siteLangId);
                            $htm = '<a href="' . UrlHelper::generateUrl('Account', 'changeEmailPassword', [], CONF_WEBROOT_DASHBOARD) . '" class="link-underline" data-bs-toggle="tooltip" title="' . $title . '">' . Labels::getLabel('LBL_PASSWORD', $siteLangId) . '</a>';
                            echo CommonHelper::replaceStringData($lbl, ['{PASSWORD}' => $htm]);
                            ?>
                        </div>
                    <?php } ?>
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