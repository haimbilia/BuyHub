<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php $this->includeTemplate('_partial/header/content-header.php'); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="cms text-center">
                    <?php if ($supplierRequest["usuprequest_status"] == User::SUPPLIER_REQUEST_PENDING) { ?>
                        <div class="block-empty">
                            <img class="block__img" width="200" height="200" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/supplier-request.svg" alt="">
                            <h3>
                                <?php echo Labels::getLabel('LBL_Hello', $siteLangId), ' ', $supplierRequest["user_name"] ?> ,
                                <br>

                                <?php echo Labels::getLabel('LBL_Thank_you_for_submitting_your_application', $siteLangId) ?>
                            </h3>
                            <p>
                                <?php echo Labels::getLabel('LBL_application_awaiting_approval', $siteLangId) ?>
                            </p>
                            <p><?php echo Labels::getLabel('LBL_Application_Reference', $siteLangId) ?>: <strong><?php echo $supplierRequest["usuprequest_reference"]; ?></strong></p>
                        </div>
                    <?php } elseif ($supplierRequest["usuprequest_status"] == User::SUPPLIER_REQUEST_APPROVED) { ?>
                        <div class="success-animation">
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle>
                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
                            </svg>
                        </div>
                        <h4><?php echo Labels::getLabel('LBL_Hello', $siteLangId), ' ', $supplierRequest["user_name"] ?> , <?php echo Labels::getLabel('LBL_Your_Application_Approved', $siteLangId) ?></h4>
                        <p><?php echo Labels::getLabel('LBL_Start_Using_Seller_Please_Contact_Us', $siteLangId) ?></p>
                        <p><?php echo Labels::getLabel('LBL_Application_Reference', $siteLangId) ?>: <strong> <?php echo $supplierRequest["usuprequest_reference"]; ?></strong></p>
                    <?php } elseif ($supplierRequest["usuprequest_status"] == User::SUPPLIER_REQUEST_CANCELLED) { ?>
                        <svg width="80" height="80" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)">
                                <circle cx="8.5" cy="8.5" r="8" />
                                <g transform="matrix(0 1 -1 0 17 0)">
                                    <path d="m5.5 11.5 6-6" />
                                    <path d="m5.5 5.5 6 6" />
                                </g>
                            </g>
                        </svg>
                        <h2><span><?php echo Labels::getLabel('LBL_Oops', $siteLangId); ?></span></h2>
                        <?php if (!empty($supplierRequest["usuprequest_comments"])) { ?>
                            <p><strong><?php echo Labels::getLabel('LBL_Reason_for_cancellation', $siteLangId) ?></strong></p><br>
                            <p><?php echo nl2br($supplierRequest["usuprequest_comments"]); ?></p>
                        <?php } ?>
                        <h4><?php echo Labels::getLabel('LBL_Hello', $siteLangId), ' ', $supplierRequest["user_name"] ?> , <?php echo Labels::getLabel('LBL_Your_Application_Declined', $siteLangId) ?></h4>

                        <a class="btn btn-secondary <?php echo ($supplierRequest['usuprequest_attempts'] >= $maxAttempts ? 'disabled' : ''); ?>" href="<?php echo UrlHelper::generateUrl('account', 'supplierApprovalForm', array('reopen')); ?>">
                            <?php echo Labels::getLabel('LBL_Submit_Revised_Request', $siteLangId) ?></a>
                        <p>
                            <?php
                            if ($supplierRequest['usuprequest_attempts'] >= $maxAttempts) {
                                echo Labels::getLabel('ERR_YOU_HAVE_ALREADY_CONSUMED_MAX_ATTEMPTS', $siteLangId);
                            }
                            ?>
                        </p>
                        <p><?php echo Labels::getLabel('LBL_Application_Reference', $siteLangId) ?>: <strong><?php echo $supplierRequest["usuprequest_reference"]; ?></strong></p>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>