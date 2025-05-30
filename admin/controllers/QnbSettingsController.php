<?php

class QnbSettingsController extends PaymentMethodSettingsController
{

    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('FRM_ENVIRONMENT', $langId), 'env', $envoirment);
        $envFld->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_ID', $langId), 'merchant_id');
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_PASSWORD', $langId), 'merchant_password');
        $frm->addRequiredField(Labels::getLabel('FRM_USER_CODE', $langId), 'user_code');
        $frm->addRequiredField(Labels::getLabel('FRM_USER_PASSWORD', $langId), 'user_password');
        return $frm;
    }

}
