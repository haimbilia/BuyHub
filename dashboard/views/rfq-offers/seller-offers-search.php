<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="listingRecordJs">
    <?php $count = 1;
    foreach ($arrListing as $sn => $row) {
        $expiredOn = $row['offer_expired_on'] != '0000-00-00 00:00:00' ? strtotime($row['offer_expired_on']) : time();
    ?>
        <div class="offers-card">
            <div class="offers-card-body">
                <div class="offers-card-head">
                    <h6 class="h6"><?php echo Labels::getLabel('LBL_SELLER_LATEST_OFFER', $siteLangId); ?><span>(<?php echo $offersCountArr[$row['offer_primary_offer_id']]['sellerOffersCount'] ?? 0; ?> <?php echo Labels::getLabel('LBL_OFFERS', $siteLangId); ?>)</span></h6>
                    <?php if ($canEdit && RequestForQuote::STATUS_CLOSED != $row['rfq_status'] && RfqOffers::STATUS_OPEN == $row['offer_status'] && !in_array(RfqOffers::STATUS_ACCEPTED, [$row['offer_status'], $row['counter_offer_status']])) { ?>
                        <div class="offers-card-head-action">
                            <button class="link-underline" onClick="editRecord(<?php echo $row['offer_id']; ?>,<?php echo  $rfqId; ?>)" data-bs-toggle="tooltip" title="<?php echo Labels::getLabel('LBL_EDIT', $siteLangId); ?>">
                                <?php echo Labels::getLabel('LBL_EDIT'); ?>
                            </button>
                        </div>
                    <?php } ?>
                </div>
                <div class="offer-block seller-block">
                    <div class="offer-block-head">
                        <?php
                        $row['shop_updated_on'] = $row['rfq_added_on'];
                        $showAdminImage = false;
                        if (1 > FatApp::getConfig('CONF_HIDE_SELLER_INFO', FatUtility::VAR_INT, 0)) {
                            $row['extra_text'] = [
                                [
                                    'class' => 'text-muted form-text',
                                    'text' => FatDate::format($row['offer_added_on'])
                                ],
                            ];
                        } else {
                            $row['shop_id'] = 0;
                            $row['shop_name'] = FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId);
                            $row['user_name'] = '';
                            $row['extra_text'] = [
                                [
                                    'class' => 'text-muted form-text',
                                    'text' => FatDate::format($row['offer_added_on'])
                                ],
                            ];
                            $showAdminImage = true;
                        }

                        $this->includeTemplate('_partial/shop/shop-info-card.php', ['shop' => $row, 'siteLangId' => $siteLangId, 'showAdminImage' => $showAdminImage], false);
                        ?>

                    </div>

                    <div class="offer-block-body">
                        <ul class="offer-stats">
                            <li class="offer-stats-item">
                                <span class="label"><?php echo Labels::getLabel('LBL_QTY', $siteLangId); ?>:</span>
                                <span class="value"><?php echo $row['offer_quantity']; ?></span>
                            </li>
                            <?php if ($row['offer_expired_on'] != '0000-00-00 00:00:00') { ?>
                                <li class="offer-stats-item">
                                    <span class="label"><?php echo Labels::getLabel('LBL_EXPIRED_ON', $siteLangId); ?>:</span>
                                    <span class="value">
                                        <?php echo FatDate::format($row['offer_expired_on']); ?>
                                        <?php if ($expiredOn < strtotime(date('Y-m-d'))) { ?>
                                            <span class="badge badge-danger ms-3"><?php echo Labels::getLabel('LBL_EXPIRED'); ?></span>
                                        <?php } ?>
                                    </span>
                                </li>
                            <?php } ?>
                            <li class="offer-stats-item offer-stats-item-rtl">
                                <span class="label">
                                    <?php
                                    $str = Labels::getLabel('LBL_COST_{PRICE}_{UNIT}', $siteLangId);
                                    echo CommonHelper::replaceStringData($str, [
                                        '{PRICE}' => CommonHelper::displayMoneyFormat($row['offer_cost']),
                                        '{UNIT}' => '<span class="per-unit">/ ' . applicationConstants::getWeightUnitName($siteLangId, $row['rfq_quantity_unit']) . '</span>',
                                    ]);
                                    ?>
                                </span>
                                <span class="value">
                                    <span class="amount-label">
                                        <?php echo Labels::getLabel('LBL_TOTAL_AMOUNT'); ?>:
                                    </span>
                                    <span class="amount">
                                        <?php echo CommonHelper::displayMoneyFormat($row['offer_cost'] * $row['offer_quantity']); ?>
                                    </span>
                                </span>
                            </li>
                            <li class="offer-stats-item offer-stats-item-rtl">
                                <span class="label">
                                    <?php
                                    $str = Labels::getLabel('LBL_OFFER_PRICE_{PRICE}_{UNIT}', $siteLangId);
                                    echo CommonHelper::replaceStringData($str, [
                                        '{PRICE}' => CommonHelper::displayMoneyFormat($row['offer_price']),
                                        '{UNIT}' => '<span class="per-unit">/ ' . applicationConstants::getWeightUnitName($siteLangId, $row['rfq_quantity_unit']) . '</span>',
                                    ]);
                                    ?>
                                </span>
                                <span class="value">
                                    <span class="amount-label">
                                        <?php echo Labels::getLabel('LBL_TOTAL_AMOUNT'); ?>:
                                    </span>
                                    <span class="amount">
                                        <?php echo CommonHelper::displayMoneyFormat($row['offer_price'] * $row['offer_quantity']); ?>
                                    </span>
                                </span>
                            </li>
                            <?php if (0 < $row['rlo_shipping_charges']) { ?>
                                <li class="offer-stats-item">
                                    <span class="label"><?php echo Labels::getLabel('LBL_SHIPPING_CHARGES', $siteLangId); ?>:</span>
                                    <span class="value">
                                        <?php echo CommonHelper::displayMoneyFormat($row['rlo_shipping_charges']); ?>
                                    </span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php if (RfqOffers::STATUS_REJECTED == $row['offer_status'] || RfqOffers::STATUS_ACCEPTED == $row['offer_status']) { ?>
                        <div class="offer-block-foot">
                            <?php if (RfqOffers::STATUS_REJECTED == $row['offer_status']) { ?>
                                <p class="note note-rejects">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#info">
                                        </use>
                                    </svg><?php echo Labels::getLabel('MSG_THIS_OFFER_HAS_BEEN_REJECTED_BY_BUYER'); ?>
                                </p>
                            <?php } ?>
                            <?php if (RfqOffers::STATUS_ACCEPTED == $row['offer_status']) { ?>
                                <p class="note note-accepted">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#info">
                                        </use>
                                    </svg><?php echo Labels::getLabel('MSG_THIS_OFFER_HAS_BEEN_ACCEPTED_BY_BUYER'); ?>
                                </p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php if (0 < $row['counter_offer_id']) { ?>
                    <div class="offers-card-head">
                        <h6 class="h6">
                            <?php echo Labels::getLabel('LBL_BUYER_QUOTED_OFFER', $siteLangId); ?>
                            <span>(<?php echo $offersCountArr[$row['offer_primary_offer_id']]['buyerOffersCount'] ?? 0; ?> <?php echo Labels::getLabel('LBL_OFFERS', $siteLangId); ?>)</span>
                        </h6>
                        <?php if (0 < $row['counter_offer_id']) {
                            if ($canEdit && RequestForQuote::STATUS_CLOSED != $row['rfq_status'] && !in_array(RfqOffers::STATUS_ACCEPTED, [$row['offer_status'], $row['counter_offer_status']])) {
                                if (RfqOffers::STATUS_OPEN == $row['counter_offer_status'] && !in_array(RfqOffers::STATUS_REJECTED, [$row['offer_status'], $row['counter_offer_status']])) { ?>
                                    <div class="offer-block-head-action">
                                        <button class="link-underline" onClick="counter(<?php echo $row['counter_offer_id']; ?>,<?php echo  $rfqId; ?>)" data-bs-toggle="tooltip" title="<?php echo Labels::getLabel('LBL_COUNTER', $siteLangId); ?>">
                                            <?php echo Labels::getLabel('LBL_REPLY'); ?>
                                        </button>
                                    </div>
                        <?php }
                            }
                        } ?>
                    </div>
                <?php } ?>
                <div class="offer-block buyer-block">
                    <?php $uploadedTime = AttachedFile::setTimeParam($row['rfq_added_on']);
                    $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'user', array($row['buyer_user_id'], ImageDimension::VIEW_MINI_THUMB, true), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>
                    <div class="offer-block-head">
                        <?php
                        $buyerUser = [
                            'user_name' => $row['buyer_user_name'],
                            'user_updated_on' => $row['rfq_added_on'],
                            'user_id' => $row['buyer_user_id'],
                            'credential_email' => $row['buyer_credential_email']
                        ];
                        if (0 < $row['counter_offer_id']) {
                            $buyerUser['extra_text'] = [
                                [
                                    'class' => 'text-muted form-text',
                                    'text' => FatDate::format($row['counter_offer_added_on'])
                                ],
                            ];
                        }
                        $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $buyerUser, 'siteLangId' => $siteLangId], false);
                        ?>
                    </div>
                    <?php if (0 < $row['counter_offer_id']) { ?>
                        <div class="offer-block-body">
                            <ul class="offer-stats">
                                <li class="offer-stats-item">
                                    <span class="label"><?php echo Labels::getLabel('LBL_QTY', $siteLangId); ?>:</span>
                                    <span class="value"><?php echo $row['counter_offer_quantity']; ?></span>
                                </li>
                                <li class="offer-stats-item offer-stats-item-rtl">
                                    <span class="label">
                                        <?php
                                        $str = Labels::getLabel('LBL_QUOTED_PRICE_{PRICE}_{UNIT}', $siteLangId);
                                        echo CommonHelper::replaceStringData($str, [
                                            '{PRICE}' => CommonHelper::displayMoneyFormat($row['counter_offer_price']),
                                            '{UNIT}' => '<span class="per-unit">/ ' . applicationConstants::getWeightUnitName($siteLangId, $row['rfq_quantity_unit']) . '</span>',
                                        ]);
                                        ?>
                                    </span>
                                    <span class="value">
                                        <span class="amount-label">
                                            <?php echo Labels::getLabel('LBL_TOTAL_AMOUNT'); ?>:
                                        </span>
                                        <span class="amount">
                                            <?php echo CommonHelper::displayMoneyFormat($row['counter_offer_price'] * $row['counter_offer_quantity']); ?>
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    <?php if (RfqOffers::STATUS_REJECTED == $row['counter_offer_status'] || RfqOffers::STATUS_ACCEPTED == $row['counter_offer_status'] || 1 > $row['counter_offer_id']) { ?>
                        <div class="offer-block-foot">
                            <?php if (RfqOffers::STATUS_REJECTED == $row['counter_offer_status']) { ?>
                                <p class="note note-rejects">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#info">
                                        </use>
                                    </svg><?php echo Labels::getLabel('MSG_THIS_OFFER_HAS_BEEN_REJECTED_BY_YOU'); ?>
                                </p>
                            <?php } ?>
                            <?php if (RfqOffers::STATUS_ACCEPTED == $row['counter_offer_status']) { ?>
                                <p class="note note-accepted">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#info">
                                        </use>
                                    </svg><?php echo Labels::getLabel('MSG_THIS_OFFER_HAS_BEEN_ACCEPTED_BY_YOU'); ?>
                                </p>
                            <?php } ?>
                            <?php if (1 > $row['counter_offer_id']) { ?>
                                <p class="note">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#info">
                                        </use>
                                    </svg><?php echo ($row['offer_negotiable']) ? Labels::getLabel('MSG_NO_OFFER_QUOTED', $siteLangId) : Labels::getLabel('MSG_NOT_OPEN_FOR_QUOTE', $siteLangId); ?>
                                </p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="offer-block actions-block">
                    <div class="actions-block-body">
                        <?php if ($canEdit && !in_array(RfqOffers::STATUS_ACCEPTED, [$row['offer_status'], $row['counter_offer_status']])) { ?>
                            <?php
                            $counterOfferId = FatUtility::int($row['counter_offer_id']);
                            $counterOfferId = 1 > $counterOfferId ? $row['offer_id'] : $counterOfferId;
                            if (in_array($row['counter_offer_status'], [RfqOffers::STATUS_OPEN, RfqOffers::STATUS_COUNTERED]) && 1 > $row['rlo_seller_acceptance']) { ?>
                                <button class="btn btn-accept btn-icon" onClick="sellerAcceptance(<?php echo $counterOfferId; ?>,<?php echo  $rfqId; ?>)" data-bs-toggle="tooltip" title="<?php echo Labels::getLabel('LBL_ACCEPT_BUYER_OFFER', $siteLangId); ?>">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#accept">
                                        </use>
                                    </svg> <?php echo Labels::getLabel('LBL_ACCEPT'); ?>
                                </button>
                            <?php }
                            if (RfqOffers::STATUS_OPEN == $row['counter_offer_status'] && $row['counter_offer_status'] != null && 1 > $row['rlo_seller_acceptance']) { ?>
                                <button class="btn btn-reject btn-icon" onClick="reject(<?php echo $row['counter_offer_id']; ?>,<?php echo $rfqId; ?>)" data-bs-toggle="tooltip" title="<?php echo Labels::getLabel('LBL_REJECT_BUYER_OFFER', $siteLangId); ?>">
                                    <svg class="svg" width="16" height="16">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#reject">
                                        </use>
                                    </svg> <?php echo Labels::getLabel('LBL_REJECT'); ?>
                                </button>
                        <?php }
                        } ?>

                        <button class="btn btn-outline-gray btn-icon" onclick="view(<?php echo $rfqId; ?>, <?php echo $row['rlo_primary_offer_id']; ?>)">
                            <svg class="svg" width="16" height="16">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#log">
                                </use>
                            </svg> <?php echo Labels::getLabel('LBL_OFFERS_LOG', $siteLangId); ?>
                        </button>

                        <?php //if (RfqOffers::STATUS_ACCEPTED == $row['offer_status'] || RfqOffers::STATUS_ACCEPTED == $row['counter_offer_status']) 
                        { ?>
                            <button class="btn btn-outline-info btn-icon" onclick="attachmentForm(<?php echo $row['rlo_primary_offer_id']; ?>)">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#linking">
                                    </use>
                                </svg> <?php echo Labels::getLabel('LBL_ATTACHMENT', $siteLangId); ?>
                            </button>
                            <button class="btn btn-outline-gray btn-icon" onclick="attachmentForm(<?php echo $row['rlo_primary_offer_id']; ?>, 0)">
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#messages">
                                    </use>
                                </svg> <?php echo Labels::getLabel('LBL_MESSAGES', $siteLangId); ?>
                            </button>
                        <?php } ?>
                    </div>
                    <div class="actions-block-foot">
                        <button class="link-black link-underline" type="button" aria-label="Shipping Rates" onclick="viewShippingRates(<?php echo $rfqId; ?>,<?php echo $row['rlo_seller_user_id']; ?>,<?php echo $row['rlo_primary_offer_id']; ?>)">
                            <?php echo Labels::getLabel('LBL_SHIPPING_RATES', $siteLangId); ?></button>
                        <?php if ($canEdit) { ?>
                            <button class="link-black link-underline" onClick="deleteRecord(<?php echo $rfqId; ?>,<?php echo $row['offer_id']; ?>)" data-bs-toggle="tooltip" title="<?php echo Labels::getLabel('LBL_REMOVE', $siteLangId); ?>"> <?php echo Labels::getLabel('LBL_REMOVE'); ?>
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (empty($arrListing)) { ?>
    <?php $message = Labels::getLabel('LBL_NO_RECORD_FOUND');
        if (RequestForQuote::STATUS_CLOSED == $rfqStatus) {
            $message =   Labels::getLabel('MSG_RFQ_HAS_BEEN_CLOSED_BY_THE_BUYER', $siteLangId);
        }
        $this->includeTemplate('_partial/no-record-found.php', ['message' => $message]);
    } ?>

    <?php
    $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSrchPaging'));
    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToSearchPage');
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
</div>