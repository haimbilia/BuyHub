<?php
$file = CONF_INSTALLATION_PATH . 'vendor/autoload.php';
if (!file_exists($file)) {
    LibHelper::exitWithError(Labels::getLabel('ERR_UNABLE_TO_LOCATE_REQUIRED_LIBRARY_FILE._PLEASE_RUN_COMPOSER_TO_INSTALL.'));
}

require_once $file;

class AffiliateBaseController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);
        if (!User::isAffiliate()) {
            if (FatUtility::isAjaxCall()) {
                Message::addErrorMessage(Labels::getLabel("LBL_Unauthorised_access", $this->siteLangId));
                FatUtility::dieWithError(Message::getHtml());
            }
            FatApp::redirectUser(UrlHelper::generateUrl('account'));
        }
        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'AFFILIATE';
        
    }
}
