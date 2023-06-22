<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php');
$yesNoArr = applicationConstants::getYesNoArr($siteLangId);
$sharingFrm->addFormTagAttribute('class', 'form');
$sharingFrm->addFormTagAttribute('onsubmit', 'setUpMailAffiliateSharing(this);return false;');
$sharingFrm->developerTags['colClassPrefix'] = 'col-xs-12 col-md-';
$sharingFrm->developerTags['fld_default_col'] = 12;

$submitFld = $sharingFrm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', "btn btn-brand");
?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Affiliate', $siteLangId),
        'siteLangId' => $siteLangId,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>

    <div class="content-body">
        <div class="row">
            <div class="col-lg-4 order-lg-2">
                <div class="widget-scroll">
                    <div class="widget widget-stats">
                        <a href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                            <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-1.png);">
                                <div class="card-head border-0">
                                    <h5 class="card-title"><?php echo Labels::getLabel('LBL_Credits', $siteLangId); ?></h5>

                                </div>
                                <div class="card-body pt-0 ">
                                    <div class="stats">
                                        <div class="stats-number">
                                            <ul>
                                                <li>
                                                    <span class="total"><?php echo Labels::getLabel('LBL_Total', $siteLangId); ?></span>
                                                    <span class="total-numbers"><?php echo CommonHelper::displayMoneyFormat($userBalance); ?></span>
                                                </li>
                                                <li>
                                                    <span class="total"><?php echo Labels::getLabel('LBL_Credits_earned_today', $siteLangId); ?></span>
                                                    <span class="total-numbers"><?php echo CommonHelper::displayMoneyFormat($txnsSummary['total_earned']); ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="widget widget-stats">
                        <a href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>">
                            <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-2.png);">
                                <div class="card-head border-0">
                                    <h5 class="card-title"><?php echo Labels::getLabel('LBL_Revenue', $siteLangId); ?></h5>
                                </div>
                                <div class="card-body pt-0 ">
                                    <div class="stats">
                                        <div class="stats-number">
                                            <ul>
                                                <li>
                                                    <span class="total"><?php echo Labels::getLabel('LBL_Total_Revenue', $siteLangId); ?></span>
                                                    <span class="total-numbers"><?php echo CommonHelper::displayMoneyFormat($userRevenue); ?></span>
                                                </li>
                                                <li>
                                                    <span class="total"><?php echo Labels::getLabel('LBL_Today_Revenue', $siteLangId); ?></span>
                                                    <span class="total-numbers"><?php echo CommonHelper::displayMoneyFormat($todayRevenue); ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="widget widget-stats">
                        <div class="card card-commerce card-commerce-bg" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>/images/card-commerce-bg-3.png);">
                            <div class="card-head border-0">
                                <h5 class="card-title">
                                    <?php echo Labels::getLabel('LBL_Share_and_earn_commission_on_every_purchase', $siteLangId) ?>
                                </h5>
                            </div>
                            <div class="card-body pt-0 ">
                                <div class="stats">
                                    <button type="button" class="btn btn-outline-gray btn-sm mt-4" title="<?php echo Labels::getLabel('MSG_COPY_TO_CLIPBOARD', $siteLangId); ?>" data-url="<?php echo $affiliateTrackingUrl; ?>" onclick="copyText(this, false)"><?php echo Labels::getLabel('LBL_Click_to_copy', $siteLangId) ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (false !== $twitterUrl) { ?>
                        <div class="widget widget-stats">
                            <button class="btn block-social mb-3" id="twitter_btn" type="button" style="background-color:#1DA1F2">
                                <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                </svg>
                                <p> <?php echo sprintf(Labels::getLabel('L_Send_a_tweet_followers', $siteLangId), '<strong>' . Labels::getLabel('L_Tweet', $siteLangId) . '</strong>') ?>
                                </p>
                                <span class="ajax_message thanks-msgX" id="twitter_ajax"></span>
                            </button>
                        </div>
                    <?php } ?>
                    <div class="widget widget-stats">
                        <button class="btn block-social openBulkEmailForm" type="button" style="background-color:#00B2FF">
                            <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                            </svg>
                            <p> <?php echo Labels::getLabel('L_Email', $siteLangId) ?>
                                <?php echo Labels::getLabel('L_Your_friend_tell_them_about_yourself', $siteLangId) ?>
                            </p>
                            <span class="ajax_message thanks-msgX"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-head border-0">
                        <h5 class="card-title "><?php echo Labels::getLabel('LBL_Referred_by_me', $siteLangId); ?>
                        </h5>
                        <?php if (count($user_listing) > 0) { ?>
                            <div class="action">
                                <a href="<?php echo UrlHelper::generateUrl('affiliate', 'referredByMe'); ?>" class="link"><?php echo Labels::getLabel('Lbl_View_All', $siteLangId); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="card-body pt-0">
                        <div class="js-scrollable table-wrap">
                            <table class="table">
                                <thead>
                                    <tr class="">
                                        <th width="40%">
                                            <?php echo Labels::getLabel('LBL_User_Detail', $siteLangId); ?></th>
                                        <th width="30%">
                                            <?php echo Labels::getLabel('Lbl_Registered_on', $siteLangId); ?></th>
                                        <th width="10%"><?php echo Labels::getLabel('LBL_Active', $siteLangId); ?>
                                        </th>
                                        <th width="20%"><?php echo Labels::getLabel('LBL_Verified', $siteLangId); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if (count($user_listing) > 0) {
                                        foreach ($user_listing as $row) {
                                    ?> <tr>
                                                <td>
                                                    <div class="product-profile__description">
                                                        <div class="product-profile__title"> <?php if ($row['user_name'] != '') {
                                                                                                    echo $row['user_name'];
                                                                                                } ?> </div>
                                                        <div class="product-profile__brand"> <?php echo $row['credential_email']; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product-profile__description">
                                                        <div class="product-profile__date" title="<?php echo Labels::getLabel('Lbl_Registered_on', $siteLangId) ?>">
                                                            <?php echo FatDate::format($row['user_regdate']); ?></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="user__status">
                                                        <?php
                                                        echo $str = isset($row['credential_active']) ? $yesNoArr[$row['credential_active']] : 'N/A'; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="user__verified">
                                                        <?php
                                                        echo $str = isset($row['credential_verified']) ? $yesNoArr[$row['credential_verified']] : 'N/A'; ?>
                                                    </div>
                                                </td>
                                            </tr> <?php
                                                }
                                            } else {
                                                    ?> <tr>
                                            <td colspan="4">
                                                <?php $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false); ?>
                                            </td>
                                        </tr> <?php
                                            } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-head border-0">
                        <h5 class="card-title ">
                            <?php echo Labels::getLabel('LBL_Transaction_History', $siteLangId); ?></h5> <?php if (count($transactions) > 0) {
                                                                                                            ?> <div class="action">
                                <a href="<?php echo UrlHelper::generateUrl('Account', 'credits'); ?>" class="link"><?php echo Labels::getLabel('Lbl_View_All', $siteLangId); ?></a>
                            </div> <?php
                                                                                                            } ?>
                    </div>
                    <div class="card-body pt-0">
                        <div class="js-scrollable table-wrap">
                            <table class="table">
                                <thead>
                                    <tr class="">
                                        <th width="30%">
                                            <?php echo Labels::getLabel('LBL_Txn._Detail', $siteLangId); ?></th>
                                        <th width="30%"><?php echo Labels::getLabel('LBL_Type', $siteLangId); ?></th>
                                        <th width="10%"><?php echo Labels::getLabel('LBL_Balance', $siteLangId); ?>
                                        </th>
                                        <th width="30%"><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?>
                                        </th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if (count($transactions) > 0) {
                                        foreach ($transactions as $row) {
                                    ?> <tr>
                                                <td>
                                                    <div class="product-profile__description">
                                                        <div class="product-profile__date">
                                                            <?php echo FatDate::format($row['utxn_date']); ?></div>
                                                        <div class="product-profile__title" title="<?php echo Labels::getLabel('Lbl_Txn._Id', $siteLangId) ?>">
                                                            <?php echo Transactions::formatTransactionNumber($row['utxn_id']); ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__type">
                                                        <div class="txn__credit">
                                                            <?php echo Labels::getLabel('Lbl_Credit', $siteLangId) ?>:
                                                            <?php echo CommonHelper::displayMoneyFormat($row['utxn_credit']); ?>
                                                        </div>
                                                        <div class="txn__debit">
                                                            <?php echo Labels::getLabel('Lbl_Debit', $siteLangId) ?>:
                                                            <?php echo CommonHelper::displayMoneyFormat($row['utxn_debit']); ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__balance">
                                                        <?php echo CommonHelper::displayMoneyFormat($row['balance']); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__status"><span class="badge badge-inline <?php echo $txnStatusClassArr[$row['utxn_status']] ?>"><?php echo $txnStatusArr[$row['utxn_status']]; ?></span>
                                                    </div>
                                                </td>
                                            </tr> <?php
                                                }
                                            } else {
                                                    ?> <tr>
                                            <td colspan="4">
                                                <?php $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false); ?>
                                            </td>
                                        </tr> <?php
                                            } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="bulkEmailForm" tabindex="-1" role="dialog" aria-labelledby="bulkEmailFormLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <?php echo Labels::getLabel('L_Invite_friends_through_email', $siteLangId) ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $sharingFrm->getFormHtml(); ?>
                                <span class="ajax_message" id="custom_ajax"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function twitter_shared(name) {
        fcom.displaySuccessMessage(langLbl.thanksForSharing);
        /* $("#twitter_ajax").html(langLbl.thanksForSharing); */
    }
</script>
<script type="text/javascript">
    var newwindow;
    var intId;

    function twitter_login() {
        var screenX = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
            screenY = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
            outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
            outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
            width = 800,
            height = 600,
            left = parseInt(screenX + ((outerWidth - width) / 2), 10),
            top = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
            features = ('width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
        newwindow = window.open('<?php echo $twitterUrl; ?>', 'Login_by_twitter', features);
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }
</script>