<?php

class PayFortStartSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TRANSACTION_MODE', $langId), 'transaction_mode', array(0 => "Test/Sandbox", "1" => "Live"), 'transaction_mode', [], Labels::getLabel('FRM_SELECT', $langId))->requirements()->setRequired();
        $frm->addRequiredField(Labels::getLabel('FRM_API_SECRET_KEY', $langId), 'secret_key');
        $frm->addRequiredField(Labels::getLabel('FRM_API_OPEN_KEY', $langId), 'open_key');

        return $frm;
    }
}
