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
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $frm = $this->getForm();
        $this->setUpShippingSettings($frm, $this->keyName);
    }

    private function getForm()
    {
        $frm = new Form('frmShippingMethods');

        $fld = $frm->addTextBox(Labels::getLabel("FRM_SHIPSTATION_API_KEY", $this->siteLangId), 'shipstation_api_key');
        $fld->htmlAfterField = "<small>" . Labels::getLabel("MSG_PLEASE_ENTER_YOUR_SHIPSTATION_API_KEY_HERE.", $this->siteLangId) . "</small>";

        $fld = $frm->addTextBox(Labels::getLabel("FRM_SHIPSTATION_API_SECRET_KEY", $this->siteLangId), 'shipstation_api_secret_key');
        $fld->htmlAfterField = "<small>" . Labels::getLabel("MSG_PLEASE_ENTER_YOUR_SHIPSTATION_API_SECRET_KEY_HERE.", $this->siteLangId) . "</small>";

        return $frm;
    }
}
