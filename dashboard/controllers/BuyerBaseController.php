<?php

class BuyerBaseController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);

        if (!User::isBuyer() || UserAuthentication::isGuestUserLogged()) {
            Message::addErrorMessage(Labels::getLabel("ERR_UNAUTHORISED_ACCESS", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('account', 'profileInfo'));
        }
        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'B';
        
    }
}
