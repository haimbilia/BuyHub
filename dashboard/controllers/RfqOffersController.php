<?php
class RfqOffersController extends BuyerBaseController
{
    use RfqOffersUtility;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->isBuyer = true;
        $this->set('isBuyer', true);
        if(1 > FatApp::getConfig('CONF_RFQ_MODULE', FatUtility::VAR_INT, 0)){
            $msg = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            LibHelper::exitWithError($msg, false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('account'));
        }
    }
}
