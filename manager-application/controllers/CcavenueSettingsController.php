<?php

class CcavenueSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_ID', $langId), 'merchant_id');
        $frm->addRequiredField(Labels::getLabel('FRM_ACCESS_CODE', $langId), 'access_code');
        $frm->addTextBox(Labels::getLabel('FRM_WORKING_KEY', $langId), 'working_key');
        return $frm;
    }
}
