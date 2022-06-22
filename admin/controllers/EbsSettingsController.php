<?php

class EbsSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_ACCOUNT_ID', $langId), 'accountId');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_KEY', $langId), 'secretKey');
        return $frm;
    }
}
