<?php

class ShipStationApiSettingsController extends ShippingSettingsController
{
    private $keyName = "shipstation_shipping";
    
    public function index()
    {
        $shippingSettings = $this->getShippingSettings($this->keyName);
        
        $frm = $this->getForm();
        $frm->fill($shippingSettings);
        
        $this->set('frm', $frm);
        $this->set('shippingMethod', $this->keyName);
        $this->_template->render(false, false);
    }
    
    public function setup()
    {
        $frm = $this->getForm();
        $this->setUpShippingSettings($frm, $this->keyName);
    }
        
    private function getForm()
    {
        $frm = new Form('frmShippingMethods');
        
        $fld = $frm->addTextBox(Labels::getLabel("LBL_Shipstation_Api_key", $this->siteLangId), 'shipstation_api_key');
        $fld->htmlAfterField = "<small>" . Labels::getLabel("LBL_Please_enter_your_shipstation_Api_Key_here.", $this->siteLangId) . "</small>";
        
        $fld = $frm->addTextBox(Labels::getLabel("LBL_Shipstation_Api_Secret_key", $this->siteLangId), 'shipstation_api_secret_key');
        $fld->htmlAfterField = "<small>" . Labels::getLabel("LBL_Please_enter_your_shipstation_api_Secret_Key_here.", $this->siteLangId) . "</small>";
        
        return $frm;
    }
}
