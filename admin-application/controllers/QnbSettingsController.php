<?php

class QnbSettingsController extends PaymentMethodSettingsController
{

    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('LBL_ENVIRONMENT', $langId), 'env', $envoirment);
        $envFld->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('LBL_MERCHANT_ID', $langId), 'merchant_id');
        $frm->addRequiredField(Labels::getLabel('LBL_MERCHANT_PASSWORD', $langId), 'merchant_password');
        $frm->addRequiredField(Labels::getLabel('LBL_USER_CODE', $langId), 'user_code');
        $frm->addRequiredField(Labels::getLabel('LBL_USER_PASSWORD', $langId), 'user_password');
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }

}
