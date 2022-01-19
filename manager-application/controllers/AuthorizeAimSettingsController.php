<?php

class AuthorizeAimSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_LOGIN_ID', $langId), 'login_id');
        $frm->addRequiredField(Labels::getLabel('FRM_TRANSACTION_KEY', $langId), 'transaction_key');
        return $frm;
    }
}
