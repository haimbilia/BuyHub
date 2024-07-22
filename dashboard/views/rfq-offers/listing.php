<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('offer_user_id');
if (null != $fld) {
    $fld->setFieldTagAttribute('id', 'rfqSellersJs');
    $fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL'));
}
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $rfqTitle = $rfqData['rfq_title'] . ' ( ' . $rfqData['rfq_number'] . ' )';
    $selprodTitleLbl = '';
    if (isset($selprodTitle) && !empty($selprodTitle)) {
        $selprodTitleLbl = Labels::getLabel('LBL_LINKED_INVENTORY:_{INVENTORY}', $siteLangId);
        $selprodTitleLbl = CommonHelper::replaceStringData($selprodTitleLbl,  ['{INVENTORY}' => $selprodTitle]);
        $rfqTitle .= '<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" data-container="body" title="' . $selprodTitleLbl . '"></i>';
    }
    
    if (RequestForQuote::STATUS_ACCEPTED == $rfqData['rfq_status']) {
        $rfqTitle .= HtmlHelper::getStatusHtml(HtmlHelper::SUCCESS, Labels::getLabel('LBL_ACCEPTED', $siteLangId));
    } else if (RequestForQuote::STATUS_CLOSED == $rfqData['rfq_status']) {
        $rfqTitle .= HtmlHelper::getStatusHtml(HtmlHelper::DANGER, Labels::getLabel('LBL_CLOSED', $siteLangId));
    }

    $ctrl = ($isSeller ? 'Seller' : '') . 'RequestForQuotes';
    $backBtnUrl = UrlHelper::generateUrl($ctrl);
    if ($isGlobal) {
        $backBtnUrl = UrlHelper::generateUrl($ctrl, 'global');
    }
    $data = [
        'headingLabel' => $rfqTitle,
        'siteLangId' => $siteLangId,
        'otherButtons' => $otherButtons,
        'headingBackButton' => [
            'href' => $backBtnUrl
        ],
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="card">
            <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
        <?php 
        if ($isSeller && RequestForQuote::STATUS_ACCEPTED == $rfqData['rfq_status'] && false == RfqOffers::isAnySellerOfferAccepted($sellerId, $rfqData['rfq_id'])) {
            echo HtmlHelper::getStatusHtml(HtmlHelper::INFO, Labels::getLabel('LBL_BUYER_HAS_ALREADY_ACCEPTED_AN_OFFER_FROM_ANOTHER_SELLER', $siteLangId));
        } ?>
        </div>
        <div id="listing"></div>
    </div>
</div>