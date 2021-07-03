<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card">
    <div class="card-body">
        <div class="row justify-content-center my-5">
            <div class="col-lg-8">
                <?php if (empty($accountId)) { ?>
                    <div class="features-block">
                        <div class="features-block_head">
                            <h4><?php echo Labels::getLabel('LBL_FEATURES', $siteLangId); ?></h4>
                            <p><?php echo Labels::getLabel('API_CONNECT_FLEXIBLE_SET_OF_FEATURES_INCLUDES', $siteLangId); ?></p>
                        </div>
                        <ul class="features-block_list">
                            <li>
                                <p><strong><?php echo Labels::getLabel('LBL_PAYOUTS', $siteLangId); ?></strong>:</p>
                                <p><?php echo Labels::getLabel('API_ROUTE_FUNDS_TO_YOUR_RECIPIENTS', $siteLangId); ?></p>
                            </li>

                            <li>
                                <p> <strong><?php echo Labels::getLabel('LBL_FEE_COLLECTION', $siteLangId); ?></strong>: </p>
                                <p> <?php echo Labels::getLabel('API_DRIVE_REVENUE_FOR_YOUR_BUSINESS', $siteLangId); ?> </p>
                            </li>
                            <li>
                                <p> <strong><?php echo Labels::getLabel('API_ONBOARDING', $siteLangId); ?></strong>:</p>
                                <p> <?php echo Labels::getLabel('API_MOBILE_FRIENDLY_AND_CONVERSION_OPTIMIZED_UI', $siteLangId); ?> </p>
                            </li>
                        </ul>
                        <div class="text-center"> 
                            <a class="btn btn-outline-brand btn-sm mr-2" onClick="register(this)" href="javascript:void(0)" data-href="<?php echo UrlHelper::generateUrl($keyName, 'register'); ?>">
                                <?php echo Labels::getLabel('LBL_REGISTER', $siteLangId); ?>
                            </a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="text-center">
                        <h5><?php echo Labels::getLabel('LBL_ACCOUNT_ID', $siteLangId); ?> : <?php echo $accountId; ?></h5>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ('custom' == $stripeAccountType) { ?>
                                    <a class="btn btn-brand btn-sm" onClick="deleteAccount(this)" href="javascript:void(0)" data-href="<?php echo UrlHelper::generateUrl($keyName, 'deleteAccount') ?>" title="<?php echo Labels::getLabel('LBL_DELETE_ACCOUNT', $siteLangId); ?>">
                                        <?php echo Labels::getLabel('LBL_DELETE_ACCOUNT', $siteLangId); ?>
                                    </a>
                                <?php } ?>
                                <a class="btn btn-outline-brand btn-sm" onClick="unlinkAccount(this)" href="javascript:void(0)" data-href="<?php echo UrlHelper::generateUrl($keyName, 'unlinkAccount') ?>" title="<?php echo Labels::getLabel('LBL_UNLINK_ACCOUNT', $siteLangId); ?>">
                                    <?php echo Labels::getLabel('LBL_UNLINK_ACCOUNT', $siteLangId); ?>
                                </a>
                                <?php if (!empty($accountId) && true === $initialFormSubmitted && false === $userAccountIsValid) { 
                                    $msg = Labels::getLabel('MSG_STRIPE_CONNECT_ACCOUNT_NOT_COMPLETE', $siteLangId);
                                    $htm = '<a href="javascript:void(0);" onClick="completeAccount(this)" data-href="' . UrlHelper::generateUrl($keyName, 'completeAccount') . '">' . Labels::getLabel('LBL_CLICK_HERE', $siteLangId) . '</a>';
                                    $msg = CommonHelper::replaceStringData($msg, ['{CLICK-HERE}' => $htm]);
                                    ?>
                                    <ul class="errorlist erlist_merchantCatCode mt-4">
                                        <li>
                                            <?php echo $msg; ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($loginUrl)) { ?>
                    <a class="btn btn-brand btn-sm" href="<?php echo $loginUrl; ?>" target="_blank">
                        <?php echo Labels::getLabel('LBL_STRIPE_DASHBOARD', $siteLangId); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
        <?php if (!empty($requiredFields) && !empty($accountId)) { ?>
            <div class="row">
                <div class="col-md-12 requiredFieldsForm-js"></div>
            </div>
            <script>
                requiredFieldsForm();
            </script>
        <?php } elseif (!empty($accountId) && !empty($stripeUserData)) { ?>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <ul class="stripe-stats">
                        <li>
                            <div class="stats">
                                <p>
                                    <b><?php echo Labels::getLabel('MSG_PAYOUTS', $siteLangId); ?> : </b>
                                    <?php echo ucwords($stripeUserData['settings']['payouts']['schedule']['interval']); ?>
                                </p>
                                <div class="divider"></div>
                                <span class="title"><?php echo Labels::getLabel('MSG_BANK_DETAIL', $siteLangId); ?></span>
                                <?php foreach ($stripeUserData['external_accounts']['data'] as $index => $bank) { ?>
                                    <p>
                                        <?php echo Labels::getLabel('MSG_BANK_NAME', $siteLangId); ?> : <?php echo $bank['bank_name']; ?>
                                    </p>
                                    <p><?php echo Labels::getLabel('MSG_ACCOUNT_HOLDER_NAME', $siteLangId); ?> :
                                        <?php echo $bank['account_holder_name']; ?></p>
                                    <p><?php echo Labels::getLabel('MSG_ACCOUNT_NUMBER', $siteLangId); ?> :
                                        <?php echo '****' . $bank['last4']; ?></p>
                                    <p><?php echo Labels::getLabel('MSG_ROUTING_NUMBER', $siteLangId); ?> :
                                        <?php echo $bank['routing_number']; ?></p>
                                    <?php if (($index + 1) < count($stripeUserData['external_accounts']['data'])) { ?>

                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    var keyName = '<?php echo $keyName; ?>';
</script>