<?php

class BraintreeSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANTID', $langId), 'merchant_id');
        $frm->addRequiredField(Labels::getLabel('FRM_PUBLIC_KEY', $langId), 'public_key');
        $frm->addRequiredField(Labels::getLabel('FRM_PRIVATE_KEY', $langId), 'private_key');
        return $frm;
    }
}
