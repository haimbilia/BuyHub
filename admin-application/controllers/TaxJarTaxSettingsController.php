<?php

class TaxJarTaxSettingsController extends TaxSettingsController
{
    public static function form(int $langId)
    {
        $frm = new Form('frmPayPal');

        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('LBL_ENVOIRMENT', $langId), 'env', $envoirment, '', ['class' => 'fieldsVisibility-js'], '');
        $envFld->requirement->setRequired(true);

        $signupLink = '<a href="https://app.taxjar.com/api_sign_up" target="_blank">' . Labels::getLabel('LBL_SIGN_UP', $langId) . '</a>';
        $signupLabel = Labels::getLabel('LBL_{SIGN-UP}_FOR_TAXJAR_AND_GENERATE_A_NEW_TOKEN.', $langId);
        $signupLabel = CommonHelper::replaceStringData($signupLabel, ['{SIGN-UP}' => $signupLink]);
        
        $tokenLink = '<a href="https://support.taxjar.com/article/160-how-do-i-get-a-taxjar-sales-tax-api-token" target="_blank">' . Labels::getLabel('LBL_API_TOKEN?_|_TAXJAR_SUPPORT.', $langId) . '</a>';
        $tokenLabel = Labels::getLabel('LBL_HOW_DO_I_GET_A_TAXJAR_{API-TOKEN}', $langId);
        $tokenLabel = CommonHelper::replaceStringData($tokenLabel, ['{API-TOKEN}' => $tokenLink]);
        
        $exportLink = '<a href="https://app.taxjar.com/api_sign_up" target="_blank">' . Labels::getLabel('LBL_EXPORT', $langId) . '</a>';
        $exportLabel = Labels::getLabel('LBL_{EXPORT}_OLD_TRANSACTIONS_TO_CSV', $langId);
        $exportLabel = CommonHelper::replaceStringData($exportLabel, ['{EXPORT}' => $exportLink]);

        $htmlAfterField = '<ul>
            <li>' . $signupLabel . '</li>
            <li>' . $tokenLabel . '</li>
            <li>' . $exportLabel . '</li>                
        </ul>';

        $fld = $frm->addTextBox(Labels::getLabel('LBL_API_TOKEN', $langId), 'sandbox_key');
        $fld->htmlAfterField = $htmlAfterField;
        $sandBoxFld = new FormFieldRequirement('sandbox_key', Labels::getLabel('LBL_API_TOKEN', $langId));
        $sandBoxFld->setRequired(false);
        $reqSandBoxFld = new FormFieldRequirement('sandbox_key', Labels::getLabel('LBL_API_TOKEN', $langId));
        $reqSandBoxFld->setRequired(true);

        $fld = $frm->addTextBox(Labels::getLabel('LBL_API_TOKEN', $langId), 'live_key');
        $fld->htmlAfterField = $htmlAfterField;
        $liveKeyFld = new FormFieldRequirement('live_key', Labels::getLabel('LBL_API_TOKEN', $langId));
        $liveKeyFld->setRequired(false);
        $reqLiveKeyFld = new FormFieldRequirement('live_key', Labels::getLabel('LBL_API_TOKEN', $langId));
        $reqLiveKeyFld->setRequired(true);

        $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_SANDBOX, 'eq', 'sandbox_key', $reqSandBoxFld);
        $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_SANDBOX, 'eq', 'live_key', $liveKeyFld);

        $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_PRODUCTION, 'eq', 'sandbox_key', $sandBoxFld);
        $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_PRODUCTION, 'eq', 'live_key', $reqLiveKeyFld);

        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }
}
