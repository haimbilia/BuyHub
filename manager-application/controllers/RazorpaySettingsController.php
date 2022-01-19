<?php

class RazorpaySettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_KEY_ID', $langId), 'merchant_key_id');
        $frm->addRequiredField(Labels::getLabel('FRM_KEY_SECRET', $langId), 'merchant_key_secret');
        return $frm;
    }
}
