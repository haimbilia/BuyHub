<?php

class PayuMoneySettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_KEY', $langId), 'merchant_key');
        $frm->addRequiredField(Labels::getLabel('FRM_SALT', $langId), 'salt');
        return $frm;
    }
}
