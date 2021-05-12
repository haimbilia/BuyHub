<?php

class AramexSettingsController extends ShippingServicesSettingsController
{
    private const KEY_NAME = 'Aramex';
    public static function form(int $langId)
    {
        $frm = new Form('frm' . self::KEY_NAME);

        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('LBL_ENVOIRMENT', $langId), 'env', $envoirment, '', ['class' => 'fieldsVisibility-js'], '');
        $envFld->requirement->setRequired(true);

        $plugin = PluginHelper::callPlugin(self::KEY_NAME, [$langId], $error, $langId, false);
        $labelsArr = $plugin->getColsLabelArr();
        foreach ($labelsArr as $colName => $colLabel) {
            /* Sanbox Key Field */
            $fieldFn = ('password'== strtolower($colName)) ? 'addPasswordField' : 'addTextBox';
            $frm->$fieldFn($colLabel, $colName);

            $fld = new FormFieldRequirement($colName, $colLabel);
            $fld->setRequired(false);
            $reqFld = new FormFieldRequirement($colName, $colLabel);
            $reqFld->setRequired(true);

            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_SANDBOX, 'eq', $colName, $reqFld);
            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_PRODUCTION, 'eq', $colName, $fld);
            /* Sanbox Key Field */

            /* Live Key Fields */
            $colName = 'live_' . $colName;
            $frm->$fieldFn($colLabel, $colName);

            $fld = new FormFieldRequirement($colName, $colLabel);
            $fld->setRequired(false);
            $reqFld = new FormFieldRequirement($colName, $colLabel);
            $reqFld->setRequired(true);

            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_SANDBOX, 'eq', $colName, $fld);
            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_PRODUCTION, 'eq', $colName, $reqFld);
            /* Live Key Fields */            
        }

        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }
}
