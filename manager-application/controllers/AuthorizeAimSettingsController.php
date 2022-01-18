<?php

class AuthorizeAimSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('LBL_Login_ID', $langId), 'login_id');
        $frm->addRequiredField(Labels::getLabel('LBL_Transaction_Key', $langId), 'transaction_key');
        return $frm;
    }
}
