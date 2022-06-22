<?php

class OmiseSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_PUBLIC_KEY', $langId), 'public_key');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_KEY', $langId), 'secret_key');
        return $frm;
    }
}
