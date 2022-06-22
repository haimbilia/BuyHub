<?php

class PayFortSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_IDENTIFIER', $langId), 'merchant_id');
        $frm->addRequiredField(Labels::getLabel('FRM_ACCESS_CODE', $langId), 'access_code');
        $frm->addSelectBox(Labels::getLabel('FRM_SHA_TYPE', $langId), 'sha_type', array( 'sha128' => 'SHA-128', 'sha256' => 'SHA-256', 'sha512' => 'SHA-512' ), 'sha512', [], Labels::getLabel('FRM_SELECT', $langId))->requirements()->setRequired();
        $frm->addRequiredField(Labels::getLabel('FRM_SHA_REQUEST_PHRASE', $langId), 'sha_request_phrase');
        $frm->addRequiredField(Labels::getLabel('FRM_SHA_RESPONSE_PHRASE', $langId), 'sha_response_phrase');
        return $frm;
    }
}
