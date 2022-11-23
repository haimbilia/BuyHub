<?php

class CcavenueSettingsController extends PaymentMethodSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('FRM_ENVOIRMENT', $langId), 'env', $envoirment, '', [], '');
        $envFld->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_ID', $langId), 'merchant_id');
        $frm->addRequiredField(Labels::getLabel('FRM_ACCESS_CODE', $langId), 'access_code');
        $frm->addTextBox(Labels::getLabel('FRM_ENCRYPTION_KEY/_WORKING_KEY', $langId), 'working_key');
        
        $htm = '<p class="form-text">' . Labels::getLabel('LBL_CCAVENUE_TEST_CREDENTIALS') . '<p>';
        $htm .= '<b>' . Labels::getLabel('LBL_IS_MCRYPT_EXTENSION_INSTALLED', $langId) . '</b>';
        $frm->addHTML('', '', $htm);
        return $frm;
    }
}