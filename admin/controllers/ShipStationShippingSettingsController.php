<?php

class ShipStationShippingSettingsController extends ShippingServicesSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('FRM_ENVOIRMENT', $langId), 'environment', $envoirment);
        $envFld->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('FRM_API_KEY', $langId), 'api_key');
        $frm->addRequiredField(Labels::getLabel('FRM_API_SECRET_KEY', $langId), 'api_secret_key');
        $fld = $frm->addButton("", "sync_address", Labels::getLabel("BTN_SYNC_ADMIN'S_DEFAULT_ADDRESS_ID", $langId), ['class' => 'btn btn-outline-brand', 'onclick' => 'syncDefaultAddressId();']);
        $fld->htmlAfterField ='<p class="form-text">' . Labels::getLabel('LBL_SYNC_ADMIN_SHIPSTATION_DEFAULT_ADDRESS_DESCRIPTION') . '</p>';
        return $frm;
    }
}
