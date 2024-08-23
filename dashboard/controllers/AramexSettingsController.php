<?php

class AramexSettingsController extends ShippingServicesSettingsController
{
    private const KEY_NAME = 'Aramex';
    public static function form(int $langId)
    {
        $frm = new Form('frm' . self::KEY_NAME);

        $plugin = LibHelper::callPlugin(self::KEY_NAME, [$langId], $error, $langId, false);
        $labelsArr = $plugin->getFormFieldsArr();
        foreach ($labelsArr as $colName => $colLabel) {
            $fieldFn = ('password' == strtolower($colName)) ? 'addPasswordField' : 'addTextBox';
            $fld = $frm->$fieldFn($colLabel, $colName);
            $fld->requirement->setRequired(true);
        }

        //$frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $langId));
        return $frm;
    }
}
