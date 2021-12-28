<?php

class ShippingSettingsController extends ListingBaseController
{
    public function getShippingSettings($keyName)
    {
        $shipObj = new ShippingSettings($keyName);
        $shippingSettings = $shipObj->getShippingSettings();
        
        if (!$shippingSettings) {
            LibHelper::exitWithError($shipObj->getError());
        }
        return $shippingSettings;
    }
    
    public function setUpShippingSettings($frm, $keyName)
    {
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        
        $shipObj = new ShippingSettings($keyName);
        $shippingSettings = $shipObj->getShippingSettings();
        
        if (!$shippingSettings) {
            LibHelper::exitWithError($shipObj->getError(), true);
        }
        //To Validate Credentails
        
        include_once CONF_INSTALLATION_PATH . 'library/APIs/shipstatation/ship.class.php';
        $apiKey = $post['shipstation_api_key'];
        $apiSecret = $post['shipstation_api_secret_key'];
        $Ship = new Ship();
        if (!$Ship->validateShipstationAccount($apiKey, $apiSecret)) {
            LibHelper::exitWithError($Ship->getError(), true);
        }

        $psObj = new ShippingSettings($keyName);
        if (!$psObj->saveSettings($post)) {
            LibHelper::exitWithError($psObj->getError(), true);
        }
        
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }
}
