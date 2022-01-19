<?php

class CitrusSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_VANITY_URL', $langId), 'merchant_vanity_url');
        $frm->addRequiredField(Labels::getLabel('FRM_ACCESS_KEY', $langId), 'merchant_access_key');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_KEY', $langId), 'merchant_secret_key');
        return $frm;
    }
}
