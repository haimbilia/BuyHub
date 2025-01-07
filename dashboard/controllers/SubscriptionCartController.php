<?php

class SubscriptionCartController extends DashboardBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        if (!FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE')) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl());
        }
    }

    public function index()
    {
        $sCartObj = new SubscriptionCart();
        $subscriptionArr = $sCartObj->getSubscription($this->siteLangId);
        if (count($subscriptionArr) == 0) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('seller', 'packages'));
        }
        $this->_template->render();
    }

    public function listing()
    {
        $templateName = 'subscription-cart/listing.php';

        $sCartObj = new SubscriptionCart();
        $subscriptionArr = $sCartObj->getSubscription($this->siteLangId);

        if ($subscriptionArr) {
            $cartSummary = $sCartObj->getSubscriptionCartFinancialSummary($this->siteLangId);


            /* $PromoCouponsFrm = $this->getPromoCouponsForm($this->siteLangId); */
            $this->set('subscriptionArr', $subscriptionArr);

            /* $this->set('PromoCouponsFrm', $PromoCouponsFrm ); */
            $this->set('cartSummary', $cartSummary);
        }
        $this->_template->render(false, false, $templateName);
    }

    public function add()
    {
        $user_id = User::getUserParentId(UserAuthentication::getLoggedUserId(true));
        $post = FatApp::getPostedData();
        if (false == $post) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl());
        }
        $spplan_id = FatApp::getPostedData('spplan_id', FatUtility::VAR_INT, 0);

        if ($spplan_id <= 0) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_PLAN_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $srch = new SellerPackagePlansSearch($this->siteLangId);
        $srch->addCondition(SellerPackagePlans::DB_TBL_PREFIX . 'active', '=', applicationConstants::ACTIVE);
        $srch->addCondition(SellerPackagePlans::DB_TBL_PREFIX . 'id', '=', $spplan_id);
        $srch->addMultipleFields(
            array(
                'spplan_id'
            )
        );
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $sellerPlanRow = $db->fetch($rs);
        if (!$sellerPlanRow || $sellerPlanRow['spplan_id'] != $spplan_id) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $spplan_id = FatUtility::int($sellerPlanRow['spplan_id']);
        /* Subscription Downgrade And Upgrade Check check[ */
        if (!UserPrivilege::canSellerUpgradeOrDowngradePlan($user_id, $spplan_id, $this->siteLangId)) {
            FatUtility::dieWithError(Message::getHtml());
        }
        /* ] */

        $subsObj = new SubscriptionCart($user_id);

        $subsObj->add($spplan_id);
        $subsObj->adjustPreviousPlan($this->siteLangId);

        Message::addMessage(Labels::getLabel('MSG_SUCCESS_SUBSCRIPTION_CART_ADD', $this->siteLangId));

        $this->set('msg', Labels::getLabel("MSG_SUBSCRIPTION_PACKAGE_SELECTED", $this->siteLangId));

        $this->set('success_msg', CommonHelper::renderHtml(Message::getHtml()));

        $this->_template->render(false, false, 'json-success.php', false, false);
    }

    public function remove()
    {
        $post = FatApp::getPostedData();
        if (false == $post) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl());
        }

        if (!isset($post['key'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $sCartObj = new SubscriptionCart();
        if (!$sCartObj->remove($post['key'])) {
            Message::addMessage($sCartObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        $this->set('msg', Labels::getLabel("MSG_Item_removed_successfully", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
