<?php

class CashOnDeliverySettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmCashOnDelivery');

        $yesNoArr = applicationConstants::getYesNoArr($langId);
        $otpVerFld = $frm->addSelectBox(Labels::getLabel('FRM_OTP_VERIFICATION', $langId), 'otp_verification', array_reverse($yesNoArr), '', ['class' => 'fieldsVisibilityJs'], '');
        $otpVerFld->requirement->setRequired(true);
        return $frm;
    }
}
