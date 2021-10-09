<?php

class PayuMoneySettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('LBL_Merchant_Key', $langId), 'merchant_key');
        $frm->addRequiredField(Labels::getLabel('LBL_Salt', $langId), 'salt');
        return $frm;
    }
}
