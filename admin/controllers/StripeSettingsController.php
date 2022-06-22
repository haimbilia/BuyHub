<?php

class StripeSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_KEY', $langId), 'privateKey');
        $frm->addRequiredField(Labels::getLabel('FRM_PUBLISHABLE_KEY', $langId), 'publishableKey');
        return $frm;
    }
}
