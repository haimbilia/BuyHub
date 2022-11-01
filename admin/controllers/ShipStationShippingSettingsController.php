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
        $fld = $frm->addHtml('', 'sync_address', HtmlHelper::addButtonHtml(Labels::getLabel("BTN_SYNC_DEFAULT_ADDRESS", $langId), 'button', 'sync_address', 'btn btn-outline-brand', 'syncDefaultAddressId()'));
        $fld->htmlAfterField ='<p class="form-text">' . Labels::getLabel('LBL_SYNC_SHIPSTATION_DEFAULT_ADDRESS_DESCRIPTION') . '</p>';
        return $frm;
    }
}
