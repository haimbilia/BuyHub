<?php

class AmazonSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_ID', $langId), 'amazon_merchantId');
        $frm->addRequiredField(Labels::getLabel('FRM_ACCESS_KEY', $langId), 'amazon_accessKey');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_KEY', $langId), 'amazon_secretKey');
        $frm->addRequiredField(Labels::getLabel('FRM_CLIENT_ID', $langId), 'amazon_clientId');
        return $frm;
    }
}
