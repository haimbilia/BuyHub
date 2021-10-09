<?php

class StripeSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('LBL_Secret_Key', $langId), 'privateKey');
        $frm->addRequiredField(Labels::getLabel('LBL_Publishable_Key', $langId), 'publishableKey');
        return $frm;
    }
}
