<?php

class KhipuSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('FRM_RECEIVER_ID', $langId), 'receiver_id');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_KEY', $langId), 'secret_key');
        return $frm;
    }
}
