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
            $fieldFn = ('password'== strtolower($colName)) ? 'addPasswordField' : 'addTextBox';
            $fld = $frm->$fieldFn($colLabel, $colName);
            $fld->requirement->setRequired(true);
        }

        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }
}
