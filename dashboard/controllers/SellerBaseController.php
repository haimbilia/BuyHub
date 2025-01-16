<?php

class SellerBaseController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);
        if (UserAuthentication::isGuestUserLogged()) {
            $msg = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            LibHelper::exitWithError($msg, false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('account'));
        }

        if (!User::canAccessSupplierDashboard() || !User::isSellerVerified($this->userParentId)) {
            $adminLoggedIn = isset($_SESSION[User::ADMIN_SESSION_ELEMENT_NAME]) ? true : false;
            $userObj = new User(UserAuthentication::getLoggedUserId());
            $userEmail = current($userObj->getUserInfo('credential_email', !$adminLoggedIn, !$adminLoggedIn));
            if (empty($userEmail)) {
                $msg = Labels::getLabel('ERR_CONFIGURE_YOUR_EMAIL_FIRST', $this->siteLangId);
                LibHelper::exitWithError($msg, false, true);
                FatApp::redirectUser(UrlHelper::generateUrl('account', 'changeEmailPassword', [], CONF_WEBROOT_DASHBOARD));
            }
            if (!FatApp::getConfig('CONF_BUYER_CAN_SEE_SELLER_TAB', FatUtility::VAR_INT, 0)) {
                LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_DASHBOARD_ACCESS', $this->siteLangId), false, true);
            }

            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'supplierApprovalForm'));
        }
        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'S';

        /* Validate Seller If stripe connect correctly configured. */
        $isStripeConnectLogin = (get_called_class() == 'StripeConnectController' && in_array($action, ['login', 'callback']));
        $stripeConnectObj = LibHelper::callPlugin('StripeConnect', [$this->siteLangId]);
        if (false !== $stripeConnectObj) {
            if (
                0 < $stripeConnectObj->isMandatoryForSeller() &&
                (false === $stripeConnectObj->init($this->userParentId, true) ||
                    false === $stripeConnectObj->userAccountIsValid()
                ) &&
                !$isStripeConnectLogin &&
                !FatUtility::isAjaxCall() &&
                UserPrivilege::isUserHasValidSubsription($this->userParentId) &&
                !empty($action) &&
                !in_array(strtolower($action), ['shopform', 'shop', 'setuprequiredfields'])
            ) {
                if (true === MOBILE_APP_API_CALL) {
                    $msg = Labels::getLabel('MSG_PLEASE_CONFIGURE_STRIPE_ACCOUNT', $this->siteLangId);
                    FatUtility::dieJsonError($msg);
                } else {
                    Message::addErrorMessage(Labels::getLabel('ERR_PLEASE_CONFIGURE_STRIPE_ACCOUNT', $this->siteLangId));
                }
                FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'shop', ['StripeConnect']));
            }
        }
        /* ----------------- */
    }

    public function imgCropper()
    {
        $this->set('title', FatApp::getPostedData('title', FatUtility::VAR_STRING, Labels::getLabel('LBL_UPLOAD_IMAGE', $this->siteLangId)));
        $this->set('html', $this->_template->render(false, false, 'cropper/index.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    protected function isShopActive($userId, $shopId = 0, $returnResult = false)
    {
        $shop = new Shop($shopId, $userId);
        if (false == $returnResult) {
            return $shop->isActive();
        }

        if ($shop->isActive()) {
            return $shop->getData();
        }

        return false;
    }
}
