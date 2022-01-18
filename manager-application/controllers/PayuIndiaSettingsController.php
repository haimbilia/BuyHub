<?php

class PayuIndiaSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_KEY', $langId), 'merchant_id');
        $frm->addRequiredField(Labels::getLabel('FRM_SALT', $langId), 'salt');
        return $frm;
    }
}
